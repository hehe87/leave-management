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
    Function Name	: 	isAllowed
    Author Name		:		Jack Braj
    Date			    :		June 09, 2014
    Parameters		:	  leave_id
    Purpose			  :		This function is to determine whether a leave or csr has been approved by all approvers or not
	*/

  public static function isAllowed( $leave_id )
  {
  	$leave = Leave::find($leave_id);
  	if($leave->leaveStatus() == "APPROVED"){
  		return true;
  	}
    $total = self::where('leave_id', '=', $leave_id);
    $approved = self::where('leave_id', '=', $leave_id)->where('approved', '=', 'YES');

    if( $total->count() == $approved->count() )
      return true;

    return false;
  }

	public function approvalNotification($approvalId)
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
		}
		else
		{
			$subject = "Request For $leave_type Rejected";
		}

	            // Get user who has requested a leave or CSR
	            $requesting_user = User::find($leave->user_id)->toArray();

	            $approvers = Approval::where('leave_id', '=', $leave->id);

	            foreach ($approvers as $approver)
	            		$approver_users[]  = User::find($approver->approver_id)->toArray();

		// if leave type is a CSR then store this as well
		if ( "CSR" == $approval->leave->leave_type ) {
			$csr = $approval->leave->csrs->toArray();
		}
		print_r($approver_users);
		// merge all data into an array
		$data = array_merge($requesting_user,$approver_users,$csr);


	             //Send email notification to approver
	            Mail::queue('emails.leave_approval', $data,  function($message) use($requesting_user, $subject)
	            {
	                $message->from('jack.braj@ithands.net', 'Admin');
	                $message->to($requesting_user->email, $requesting_user->name);
	                $message->subject($subject);
	            });
	}
	}
}