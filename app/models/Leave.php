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
		'user_id' => 'required|integer',
		'leave_date'  => 'date|date_format:Y-m-d',
		'leave_type'  => 'required|in:LEAVE,CSR',
		'reason'	  => 'required'
	];

	// fillable fields
	protected $fillable = ['user_id', 'leave_type', 'leave_date', 'from_time', 'to_time', 'reason'];

}