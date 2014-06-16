<?php
/**
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

	// Validation Rules
	public static $rules = [
		'leave_option' => 'required|in:LEAVE,CSR',
		'leave_date'  => 'required',
		'leave_type'  => 'required|in:LEAVE,CSR,FH,SH,LONG,MULTI',
		'reason'	  => 'required',		
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
  
  public function csrs()
  {
    return $this->hasMany('Csr');
  }

	/**
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
	
	
	/**
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
		
		
		switch($requiredStatus){
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
		}
	}
	
	
}