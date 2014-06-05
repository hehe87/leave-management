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

	// Validation Rules
	public static $rules = [		
		'leave_date'  => 'required|date|date_format:Y-m-d',
		'leave_type'  => 'required|in:LEAVE,CSR',
		'reason'	  => 'required',		
	];

	// fillable fields
	protected $fillable = ['user_id', 'leave_type', 'leave_date', 'from_time', 'to_time', 'reason'];
	
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
	
	
}