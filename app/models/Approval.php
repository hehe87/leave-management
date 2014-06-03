<?php

class Approval extends \Eloquent {
	protected $fillable = ['approver_id', 'leave_id', 'approved', 'approval_note'];
	
	public function leave()
	{
		return $this->belongsTo('Leave');
	}
}