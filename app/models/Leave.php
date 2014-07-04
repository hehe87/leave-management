<?php
/*
  Class Name					:	Leave
  author 						:	Jack Braj
  Date							:	June 02, 2014
  Purpose						:	Model class for leaves table
  Table referred				:	leaves
  Table updated					:	leaves
  Most Important Related Files	:   /app/models/Leave.php
*/

class Leave extends \Eloquent {
	const APPROVED_BY_NONE = 0;
	const APPROVED_BY_SOME = 1;
	const REJECTED_BY_SOME = 2;
	const APPROVED_BY_ALL  = 3;
	const REJECTED_BY_ALL  = 4;
	const PENDING 		   = 5;
	const APPROVED_BY_ADMIN = 6;

	// Validation Rules
	public static $rules = [
		'leave_option' => 'required|in:LEAVE,CSR',
		'leave_date'  => 'required',
		'leave_type'  => 'required|in:LEAVE,CSR,FH,SH,LONG,MULTI',
		'reason'       => array('required', 'max:255'),
            	];

	// fillable fields
	protected $fillable = ['user_id', 'leave_type', 'leave_date', 'leave_to', 'from_time', 'to_time', 'reason'];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function approvals()
	{
		return $this->hasMany('Approval');
	}

	/*
		Function Name	: 		pendingLeaves
		Author Name		:		Nicolas Naresh
		Date			:		June 20, 2014
		Parameters		:	    --
		Purpose			:		This function retuns an array of pending leaves for all users
	*/
	public static function pendingLeaves(){
		$leaves = Leave::all();
		$pendingLeaves = array();
		foreach($leaves as $leave){
			if($leave->approvalStatus( Leave::PENDING ) && !$leave->approvalStatus( Leave::APPROVED_BY_ADMIN)){
				$pendingLeaves[] = $leave;
			}
		}
		return $pendingLeaves;
	}



	public function csrs()
	{
		return $this->hasMany('Csr');
	}

	/*
	Function Name	: 		normalizeInput
	Author Name		:		Jack Braj
	Date			:		June 03, 2014
	Parameters		:	    array of inputs
	Purpose			:		This function used to normalize time slots to save into database
	*/

	public static function normalizeInput($inputs)
	{
		$row = [];

		foreach($inputs['from_hour'] as $tempKey => $tempData)
		{
			$row[$tempKey] = ['user_id' => $inputs['user_id'], 'leave_date' => $inputs['leave_date'], 'leave_type' => $inputs['leave_type'], 'from_time' => $inputs['from_hour'][$tempKey].':'.$inputs['from_min'][$tempKey], 'to_time' => $inputs['to_hour'][$tempKey].':'.$inputs['to_min'][$tempKey], 'reason' => $inputs['reason'], 'approver_id' => $inputs['approver_id']];
		}

		return $row;
	}


	/*
	Function Name	: 		isApproved
	Author Name		:	Jack Braj
	Date			:	June 03, 2014
	Parameters		:	-
	Purpose			:	This function returns boolean value based on $approveStage parameter value
	Return			:	one of following values: APPROVED_BY_ALL, REJECTED_BY_ALL, APPROVED_BY_SOME, APPROVED_BY_NONE
	*/

	public function approvalStatus($requiredStatus)
	{
		$allApprovals = $this->approvals->toArray();
		$approvedApprovals = Approval::where("leave_id",$this->id)->where("approved", "YES")->get()->toArray();
		$rejectedApprovals = Approval::where("leave_id",$this->id)->where("approved", "NO")->get()->toArray();
		$admins = User::where("employeeType","ADMIN")->lists("id","id");

		$adminApprovals = Approval::where("leave_id", $this->id)->where("approved","YES")->whereIn("approver_id", $admins)->count();		


		switch($requiredStatus){
			case Leave::APPROVED_BY_ADMIN:
				return ($adminApprovals > 0);
			case Leave::APPROVED_BY_SOME:
				return count($approvedApprovals) >= 1;
			case Leave::APPROVED_BY_ALL:
				return count($allApprovals) == count($approvedApprovals);
			case Leave::APPROVED_BY_NONE:
				return count($approvedApprovals) == 0;
			case Leave::REJECTED_BY_ALL:
				return count($allApprovals) == count($rejectedApprovals);
			case Leave::REJECTED_BY_SOME:
				return count($rejectedApprovals) > 0;
			case Leave::PENDING:
				return (count($allApprovals) - (count($rejectedApprovals) + count($approvedApprovals))) > 0;
		}
	}


	/*
	Function Name          : 		leaveStatus
	Author Name		:		Jack Braj
	Date			:		June 19, 2014
	Parameters		:		leaveId
	Purpose		:		This function used to return status of a leave (PENDING|APPROVED|REJECTED)
	*/

	public function leaveStatus()
	{
		if($this->approvalStatus(Leave::APPROVED_BY_ADMIN)){
			return "APPROVED";
		}
		if ($this->approvalStatus(Leave::APPROVED_BY_ALL))
			return "APPROVED";
		elseif($this->approvalStatus(Leave::REJECTED_BY_ALL) || $this->approvalStatus(Leave::REJECTED_BY_SOME))
			return "REJECTED";
		elseif( $this->approvalStatus( Leave::PENDING ) )
			return "PENDING";
	}

	public function leaveNotification($leaveId)
	{
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
        }


}