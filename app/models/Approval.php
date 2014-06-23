<?php

class Approval extends \Eloquent {
	protected $fillable = ['approver_id', 'leave_id', 'approved', 'approval_note'];

    /**
     * Function Name    :  boot
     * Author Name       :  Jack Braj
     * Date                   :  June 18, 2014
     * Parameters         :   none
     * Purpose              :   To listen to Model events for sending email notifications
     */
    public static function boot()
    {
 	parent::boot();

	static::created(function($approval){

            // Get user who has requested a leave or CSR
            $requesting_user = User::find(Auth::user()->id);

            // Get approver details
            $approver_user = User::find($approval->approver_id);

            // Construct subject line for the email
			$request_type	 = TemplateFunction::getFullLeaveTypeName($approval->leave->leave_type);
			$subject      	 = "$request_type request from $requesting_user->name";

            // form a data array to be passed in view
            $data = [];
			$data['requesting_user'] = $requesting_user->toArray();

			// Get leave details
			$leave = Leave::find($approval->leave_id);
			$data['leave'] = $leave->toArray();

			// if leave type is a CSR then merge this as well in data
			if ( "CSR" == $approval->leave->leave_type ) {
				$data['csr'] = $approval->leave->csrs->toArray();
			}

         	//Send email notification to approver
            Mail::queue('emails.leave_request', $data,  function($message) use($approver_user, $subject)
            {
                $message->from('jack.braj@ithands.net', 'Admin');
                $message->to($approver_user->email, $approver_user->name);
                $message->subject($subject);
            });

        }); //end of created
    }

	/*
    Function Name	: 		pending
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    	none
    Purpose		:		This function used to return leave relationship
	*/

	public function leave()
	{
		return $this->belongsTo('Leave');
	}

	/*
    Function Name	: 		approver
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	   	none
    Purpose		:		This function used to return user relationship
	*/

	public function approver()
	{
		return $this->belongsTo('User', 'approver_id');
	}

	/*
    Function Name	: 		pending
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	   	none
    Purpose		:		This function used to return pending leave requests for approver
	*/

	public static function pending()
	{
		return Approval::where('approved', '=', 'PENDING')
						->where('approver_id', '=', Auth::user()->id)
						->get();

	}


	/*
    Function Name	: 		sendApprovalNotification
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	   	none
    Purpose			:		This function will send notification to leave requesting user providing
    						the information of Approved or Rejected Leave
	*/
	public function sendApprovalNotification(){
		$approver = $this->approver;
		$leave = $this->leave;
		$user = $leave->user;
		$setSendMail = false;
		$approvalStatus = "APPROVED";
		// checking if approver is admin
		if($approver->employeeType === "ADMIN"){
			// set google calendar event
			if($leave->approvalStatus(Leave::APPROVED_BY_ADMIN)){
				$setSendMail = true;
			}
		}
		else{
			// check if all approvers of $leave have approved the leave
			if($leave->approvalStatus(Leave::APPROVED_BY_ALL)){
				$setSendMail = true;
			}
			else{
				// check if any of the approvers of $leave has rejected the leave
				if($leave->approvalStatus(Leave::REJECTED_BY_SOME)){
					$setSendMail = true;
					$approvalStatus = "REJECTED";
				}
			}
		}

		if($setSendMail){
			$subject = "Request For " . TemplateFunction::getFullLeaveTypeName($leave->leave_type) . " Approved";
			$requesting_user = $leave->user->toArray();
			$approvals = Approval::where('leave_id', '=', $leave->id)->get();
			$approver_users = array();
			if( $approvals->count()>0) {
				foreach ($approvals as $approval) {
				  $approver = $approval->approver->toArray();
				  $approver_users[$approver["id"]] = ['name' => $approver['name'], 'status' => $approval->approved];
				}
			}
			$data['requesting_user'] = $requesting_user;
			$data['approver_users'] = $approver_users;

			if ( "CSR" == $approval->leave->leave_type ) {
				$csr = $approval->leave->csrs->toArray();
				$data['csr'] = $csr;
			}
			$data['leave']  = $leave->toArray();
			$data['approved_status'] = $approvalStatus;

	     	//Send email notification to approver
		    Mail::queue('emails.leave_approval', $data,  function($message) use($requesting_user, $subject)
		    {
		      $message->from(Config::get('mail.username', 'Admin'))->to($requesting_user['email'], $requesting_user['name'])->subject($subject);
		    });
		}
	}

	/*
    Function Name	: 		markCalendarEvent
    Author Name		:		Nicolas Naresh
    Date			:		June 23, 2014
    Parameters		:	   	none
    Purpose			:		This function marks leave event on google calendar if leave has been
    						approved by ADMIN or all Approvers of the leave
	*/
	public function markCalendarEvent(){
		$approver = $this->approver;
		$leave = $this->leave;
		$user = $leave->user;
		$setGoogleCalendarEvent = false;
		if($approver->employeeType === "ADMIN"){
			// set google calendar event
			if($leave->approvalStatus(Leave::APPROVED_BY_ADMIN)){
				$setGoogleCalendarEvent = true;
			}
		}
		else{
			// check if all approvers of $leave have approved the leave
			// if yes than set google calendar event
			if($leave->approvalStatus(Leave::APPROVED_BY_ALL)){
				$setGoogleCalendarEvent = true;
			}
		}
		if($setGoogleCalendarEvent){
			TemplateFunction::requireGoogleCalendarApi();
			$googleCreds = TemplateFunction::getGoogleCalendarCreds();
			// Check if google configurations are set properly
	 	 	if ( $googleCreds['clientId'] == '' || !strlen( $googleCreds['serviceAccountName'] ) || !strlen( $googleCreds['keyFileLocation'] )) {
	        	echo 'Missing google configurations';
	      	}
			$client = new Google_Client();
			$client->setApplicationName("Leave Management System");
			$service = new Google_Service_Calendar($client);
			if ( Session::has('service_token') ) {
				$client->setAccessToken( Session::get('service_token') );
			}
			$key = file_get_contents( $googleCreds['keyFileLocation'] );
			$cred = new Google_Auth_AssertionCredentials(
				$googleCreds['serviceAccountName'],
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

			$summary = $user->name . " " . TemplateFunction::getLeaveTypeSummary($leave->leave_type);

			switch($leave->leave_type){
				case "LEAVE":
					$startDate = $endDate = $this->leave->leave_date;
					$start->setDate($startDate);
					$end->setDate($endDate);
					break;
				case "FH":
					$startTime = $this->leave->leave_date. 'T'. $user->inTime. '.000'. Config::get('google.timezone');
					$inTime = strtotime($user->inTime);
					$outTime = strtotime($user->outTime);
					$diffTime = ($outTime - $inTime) /2;
					$outTime = date('H:i:s', ($inTime + $diffTime));
					$endTime = $this->leave->leave_date. 'T'. $outTime. '.000'. Config::get('google.timezone');
					$start->setDateTime($startTime);
	          		$end->setDateTime($endTime);
					break;
				case "SH":
					$inTime = strtotime($user->inTime);
					$outTime = strtotime($user->outTime);
					$diffTime = ($outTime - $inTime) / 2;
					$inTime = date('H:i:s',($outTime - $diffTime));
					$startTime = $this->leave->leave_date. 'T'. $inTime. '.000'. Config::get('google.timezone');
					$endTime = $this->leave->leave_date. 'T'. $user->outTime. '.000'. Config::get('google.timezone');
					$start->setDateTime($startTime);
					$end->setDateTime($endTime);
					break;
				case "LONG":
					$startDate =  $this->leave->leave_date;
					$endDate = $this->leave->leave_to;
					$start->setDate($startDate);
					// Add one day to end date since google doesn't mark event for a day when any time is not provided after midnight
					$tempDate = new DateTime($endDate);
					$tempDate->add(new DateInterval('P1D')); // P1D means a period of 1 day
					$endDate = $tempDate->format('Y-m-d');
					$end->setDate($endDate);
					break;
			}
			$arrEventTime = array();
			if($leave->leave_type != "CSR"){
				$arrEventTime[0]["start"] = $start;
				$arrEventTime[1]["end"] = $end;
				// $event->setStart($start);
				// $event->setEnd($end);
			}
			else{
				$csrs = Csr::where('leave_id', '=', $leave->id)->get();
				foreach($csrs as $key => $csr){
					$startTime = $this->leave->leave_date. 'T'. $csr->from_time. '.000'. Config::get('google.timezone');
		            $endTime = $this->leave->leave_date. 'T'. $csr->to_time. '.000'. Config::get('google.timezone');
		            $start->setDateTime($startTime);
		            $end->setDateTime($endTime);
		            $arrEventTime[$key]["start"] = $start;
		            $arrEventTime[$key]["end"] = $end;
				}
			}
			try{
				foreach($arrEventTime as $etime){
					$start = $etime["start"];
					$end = $etime["end"];
					$event->setStart($start);
					$event->setEnd($end);
					$createdEvent = $cal->events->insert(Config::get('google.calendar_id'), $event);
				}
			}
			catch(Exception $ex){
				die($ex->getMessage());
			}
		}
	}
}