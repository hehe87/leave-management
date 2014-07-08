<?php

class ApprovalController extends \BaseController {

	/*
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


	/*
    Function Name	: 		updateStatus
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to update the leave status and calendar event
	*/

	public function updateStatus()
	{
    $auth_user = Auth::user();
    if($auth_user->employeeType == "ADMIN"){
      $approval = new Approval();
      $approval->approved = "PENDING";
      $approval->approver_id = Auth::user()->id;
      $approval->approval_note = "Status Updated By Admin";
      $approval->leave_id = Input::get("leaveId");
      $approval->save();
      $approval_status = "YES";
    }
    else{
      $approval = Approval::findOrFail(Input::get('approvalId'));
      if($approval->approver_id != Auth::user()->id){
        return Response::json(array('status' => true, 'message' => 'You are not allowed to approve this leave'));
      }
      $approval_status = Input::get('approvalStatus');
    }
    $approval->approved = $approval_status;
    $approval->save();
    $approval->sendApprovalNotification();
    $approval->markCalendarEvent();
		return Response::json(array('status' => true));
	}


	/*
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
