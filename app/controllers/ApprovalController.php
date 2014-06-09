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

	/**
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
	
	
	/**
    Function Name	: 		updateStatus
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to update the leave status and calendar event
	*/
	
	public function updateStatus()
	{
		$approval = Approval::findOrFail(Input::get('approvalId'));
		$approval->approved = Input::get('approvalStatus');
		$approval->save();

    // Mark a calendar event if approved
    if( Approval::isAllowed( $approval->leave->id ) )
    {
      // Check if google configurations are set properly
      if ( self::$clientId == ''
      || !strlen( self::$serviceAccountName )
      || !strlen( self::$keyFileLocation )) {
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
       $event->setSummary($approval->leave->leave_type);       
       if( 'LEAVE' == $approval->leave->leave_type )
       {
          $startDate = $endDate = $approval->leave->leave_date;
          $start->setDate($startDate);
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
	
	
	/**
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


}
