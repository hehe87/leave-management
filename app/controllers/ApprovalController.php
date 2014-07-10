<?php

class ApprovalController extends \BaseController {

  public function __construct()
  {
    
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

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
        return Response::json(array('status' => true, 'message' => 'You are not allowed to approve this leave!'));
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


  // public function approvalNotification($approval)
  // {

  //   $subject = $requesting_user =  NULL;
  //   $approver_users = $csr = [];

  //   // Get Leave
  //   $leave = Leave::find($approval->leave_id);
  //   $leave_type = TemplateFunction::getFullLeaveTypeName($leave->leave_type);

  //   // Check whether all pending approvals has been updated
  //   $is_pending = ($leave->leaveStatus()=="PENDING");

  //   if (!$is_pending) {
  //     if($approval->isAllowed($leave->id))
  //     {
  //       $subject = "Request For $leave_type Approved";
  //       $response = "Approved";
  //     }
  //     else
  //     {
  //       $subject = "Request For $leave_type Rejected";
  //       $response = "Rejected";
  //     }

  //     // Get user who has requested a leave or CSR
  //     $requesting_user = User::find($leave->user_id)->toArray();

  //     $approvers = Approval::where('leave_id', '=', $leave->id)->get();
  //     if( $approvers->count()>0) {
  //       foreach ($approvers as $approver) {
  //         $usr = User::find($approver->approver_id)->toArray();
  //         $approver_users[$approver->approver_id] = ['name' => $usr['name'], 'status' => $approver->approved];
  //       }
  //     }
  //     $data['requesting_user'] = $requesting_user;
  //     $data['approver_users'] = $approver_users;

  //     // if leave type is a CSR then store this as well
  //     if ( "CSR" == $approval->leave->leave_type ) {
  //       $csr = $approval->leave->csrs->toArray();
  //       $data['csr'] = $csr;
  //     }

  //     $data['leave']  = $leave->toArray();
  //     $data['approved_status'] = $response;

  //      //Send email notification to approver
  //     Mail::queue('emails.leave_approval', $data,  function($message) use($requesting_user, $subject)
  //     {
  //       $message->from('jack.braj@ithands.net', 'Admin')
  //       ->to($requesting_user['email'], $requesting_user['name'])
  //       ->subject($subject);
  //     });
  //   }
  // }
}
