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
    Function Name	: 		approver
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to return user relationship
	*/
	
	public function approver()
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
  
  /**
    Function Name	: 	isAllowed
    Author Name		:		Jack Braj
    Date			    :		June 09, 2014
    Parameters		:	  leave_id
    Purpose			  :		This function is to determine whether a leave or csr has been approved by all approvers or not
	*/
  
  public static function isAllowed( $leave_id )
  {
    $total = self::where('leave_id', '=', $leave_id);
    $approved = self::where('leave_id', '=', $leave_id)->where('approved', '=', 'YES');
    
    if( $total->count() == $approved->count() )
      return true;
      
    return false;
  }
	
	
}