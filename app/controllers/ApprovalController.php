<?php

class ApprovalController extends \BaseController {

  protected static $clientId = '';
  protected static $serviceAccountName = '';
  protected static $keyFileLocation = '';

  public function __construct()
  {
    require_once( base_path() . '/vendor/google/apiclient/src/Google/Client.php' );
    require_once( base_path() . '/vendor/google/apiclient/src/Google/Service/Calendar.php' );

    self::$clientId = Config::get('google.client_id');
    self::$serviceAccountName = Config::get('google.service_account_name');
    self::$keyFileLocation = Config::get('google.key_file_location');

   }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/*
    Function Name	: 		pending
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to show pending leave request for approver
	*/

	public function pending()
	{
		$pending_approvals = Approval::pending();

		return View::make('leaves.pending')->with('leaves', $pending_approvals);
	}


	/*
    Function Name	: 		updateStatus
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to update the leave status and calendar event
	*/

	public function updateStatus()
	{
    if(Auth::user()->employeeType == "ADMIN"){
      $approval = new Approval();
      $approval->approved = "PENDING";
      $approval->approver_id = Auth::user()->id;
      $approval->approval_note = "Status Updated By Admin";
      $approval->leave_id = Input::get("leaveId");
      $approval->save();
    }
    else{
      $approval = Approval::findOrFail(Input::get('approvalId'));
      if($approval->approver_id != Auth::user()->id){
        return Response::json(array('status' => true, 'message' => 'You are not allowed to approve this leave!'));
      }
    }
    

		$approval->approved = Input::get('approvalStatus');
		$approval->save();

    // fetch leave applicant
    $user = $approval->leave->user;

    // Send Email Notification
    $this->approvalNotification($approval);

    // Mark a calendar event if approved
    if( Approval::isAllowed( $approval->leave->id ) )
    {
      // Check if google configurations are set properly
      if ( self::$clientId == '' || !strlen( self::$serviceAccountName ) || !strlen( self::$keyFileLocation )) {
        echo 'Missing google configurations';
      }
      $client = new Google_Client();
      $client->setApplicationName("Leave Management System");
      $service = new Google_Service_Calendar($client);

      if ( Session::has('service_token') ) {
        $client->setAccessToken( Session::get('service_token') );
      }
      $key = file_get_contents( self::$keyFileLocation );
      $cred = new Google_Auth_AssertionCredentials(
        self::$serviceAccountName,
        array('https://www.googleapis.com/auth/calendar'),
        $key
      );

      $client->setAssertionCredentials($cred);
      if($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
      }
      Session::put('service_token', $client->getAccessToken());

      $cal = new Google_Service_Calendar($client);

      $start = new Google_Service_Calendar_EventDateTime();
      $end = new Google_service_Calendar_EventDateTime();

      // Mark an event
      try {
       $event = new Google_Service_Calendar_Event();
       if( 'LEAVE' == $approval->leave->leave_type )
       {
          $event->setSummary( $user->name . ' (Full Day)');
          $startDate = $endDate = $approval->leave->leave_date;
          $start->setDate($startDate);
          $end->setDate($endDate);

          $event->setStart($start);
          $event->setEnd($end);

          $createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
       }
        elseif ('FH' == $approval->leave->leave_type)
        {
          $event->setSummary( $user->name . ' (First Half)');
          $startTime = $approval->leave->leave_date. 'T'. $user->inTime. '.000'. Config::get('google.timezone');

          // Calculate End time based on user in time and out time
          $inTime = strtotime($user->inTime);
          $outTime = strtotime($user->outTime);
          $diffTime = ($outTime - $inTime) /2;

          $outTime = date('H:i:s', ($inTime + $diffTime));
          $endTime = $approval->leave->leave_date. 'T'. $outTime. '.000'. Config::get('google.timezone');
          $start->setDateTime($startTime);
          $end->setDateTime($endTime);
          $event->setStart($start);
          $event->setEnd($end);

          $createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
        }
        elseif ('SH' == $approval->leave->leave_type)
        {
          $event->setSummary( $approval->leave->user->name . ' (Second Half)');
          // Calculate Start time based on user in time and out time
          $inTime = strtotime($user->inTime);
          $outTime = strtotime($user->outTime);
          $diffTime = ($outTime - $inTime) / 2;

          $inTime = date('H:i:s',($outTime - $diffTime));

          $startTime = $approval->leave->leave_date. 'T'. $inTime. '.000'. Config::get('google.timezone');


          $endTime = $approval->leave->leave_date. 'T'. $user->outTime. '.000'. Config::get('google.timezone');
          $start->setDateTime($startTime);
          $end->setDateTime($endTime);
          $event->setStart($start);
          $event->setEnd($end);

          $createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
        }

        elseif ('LONG' == $approval->leave->leave_type)
        {
          $event->setSummary( $approval->leave->user->name . ' ('. date('d-M-Y', strtotime($approval->leave->leave_date)) .' - '. date('d-M-Y',strtotime($approval->leave->leave_to)) .')');
          $startDate =  $approval->leave->leave_date;
          $endDate = $approval->leave->leave_to;
          $start->setDate($startDate);

          // Add one day to end date since google doesn't mark event for a day when any time is not provided after midnight
          $tempDate = new DateTime($endDate);
          $tempDate->add(new DateInterval('P1D')); // PID means a period of 1 day
          $endDate = $tempDate->format('Y-m-d');

          $end->setDate($endDate);
          $event->setStart($start);
          $event->setEnd($end);


          $createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
        }

       else
       {
          $csrs = Csr::where('leave_id', '=', $approval->leave_id)->get();

          foreach( $csrs as $csr )
          {
            $event->setSummary( $user->name . ' (CSR)');
            $startTime = $approval->leave->leave_date. 'T'. $csr->from_time. '.000'. Config::get('google.timezone');
            $endTime = $approval->leave->leave_date. 'T'. $csr->to_time. '.000'. Config::get('google.timezone');
            $start->setDateTime($startTime);
            $end->setDateTime($endTime);
            $event->setStart($start);
            $event->setEnd($end);

            $createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
          }
       }


      }

      catch (Exception $ex)
      {
        die($ex->getMessage());
      }

    }
		return Response::json(array('status' => true));
	}


	/*
	Function Name		:	leaveApprovals
	Author Name		:	Nicolas Naresh
	Date			:	06, June 2014
	Parameters		:	$id -> id of leave
	Purpose			:	this function provides the user with the information on
					approvals of his/her leave/csr requests
	*/

	public function leaveApprovals($id){
		$leave = Leave::find($id);
		return View::make("leaves.leaveapprovals")->with("leave", $leave);
	}


  public function approvalNotification($approval)
  {

    $subject = $requesting_user =  NULL;
    $approver_users = $csr = [];

    // Get Leave
    $leave = Leave::find($approval->leave_id);
    $leave_type = TemplateFunction::getFullLeaveTypeName($leave->leave_type);

    // Check whether all pending approvals has been updated
    $is_pending = ($leave->leaveStatus()=="PENDING");

    if (!$is_pending) {
      if($approval->isAllowed($leave->id))
      {
        $subject = "Request For $leave_type Approved";
        $response = "Approved";
      }
      else
      {
        $subject = "Request For $leave_type Rejected";
        $response = "Rejected";
      }

      // Get user who has requested a leave or CSR
      $requesting_user = User::find($leave->user_id)->toArray();

      $approvers = Approval::where('leave_id', '=', $leave->id)->get();
      if( $approvers->count()>0) {
        foreach ($approvers as $approver) {
          $usr = User::find($approver->approver_id)->toArray();
          $approver_users[$approver->approver_id] = ['name' => $usr['name'], 'status' => $approver->approved];
        }
      }
      $data['requesting_user'] = $requesting_user;
      $data['approver_users'] = $approver_users;

      // if leave type is a CSR then store this as well
      if ( "CSR" == $approval->leave->leave_type ) {
        $csr = $approval->leave->csrs->toArray();
        $data['csr'] = $csr;
      }

      $data['leave']  = $leave->toArray();
      $data['approved_status'] = $response;

       //Send email notification to approver
      Mail::queue('emails.leave_approval', $data,  function($message) use($requesting_user, $subject)
      {
        $message->from('jack.braj@ithands.net', 'Admin')
        ->to($requesting_user['email'], $requesting_user['name'])
        ->subject($subject);
      });
    }
  }
}
