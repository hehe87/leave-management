<?php

class Approval extends \Eloquent {
	protected $fillable = ['approver_id', 'leave_id', 'approved', 'approval_note'];
	
   
	/**
    Function Name	: 		pending
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to return leave relationship
	*/
	
	public function leave()
	{
		return $this->belongsTo('Leave');
	}
	
	/**
    Function Name	: 		user
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to return user relationship
	*/
	
	public function user()
	{
		return $this->belongsTo('User', 'approver_id');
	}
	
	/**
    Function Name	: 		pending
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to return pending leave requests for approver
	*/
	
	public static function pending()
	{
		return Approval::where('approved', '=', 'PENDING')
						->where('approver_id', '=', Auth::user()->id)
						->get();
						
	}
	
	
}