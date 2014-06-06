<?php
/**

  Class Name					:	LeavesController
  author 					:	Jack Braj
  Date						:	June 02, 2014
  Purpose					:	Resourceful controller for leaves

  Table referred				:	leaves, users, approvals
  Table updated					:	leaves, approvals
  Most Important Related Files			:   	/app/models/Leave.php
*/



class LeavesController extends \BaseController {
	
	public function __construct()
	{
	  $this->beforeFilter('auth');
	}


	/**
	Function Name				:	index
	Author Name					:	Jack Braj
	Date					:	June 02, 2014
	Parameters					:	none
	Purpose					:	This function used to list all leaves
	*/

	//public function __construct()
	//{
	//	$this->beforeFilter('auth');
	//}
	
	
	public function index()
	{
		$leaves = Leave::all();

		return View::make('leaves.index', compact('leaves'));
	}

	/**
	Function Name		: 		create
	Author Name		:		Jack Braj
	Date			:		June 02, 2014
	Parameters		:	   	none
	Purpose			:		This function renders leave form with user data
	*/
	
	public function create()
	{
		$users = User::where('id', '<>', Auth::user()->id)->lists('name', 'id');
		$leave = new Leave();
		return View::make('leaves.create')->with('users', $users)->with('leave' , $leave);
	}

	/**
	Function Name		: 		store
	Author Name		:		Jack Braj
	Date			:		June 02, 2014
	Parameters		:	    	none
	Purpose			:		This function used to create leave
	*/
	
	public function store()
	{
	  $validator = [];
	  $validator_leave = [];
	  $validator_csr = [];
	  $inputs = Input::all();
	  $leave = $inputs['leave'];
	  $hasLeaveError = false;
	  $hasApprovalError = false;
	  $hasCsrError = false;
	  $validator_leave = Validator::make($leave, Leave::$rules);
    
	  if($validator_leave->fails())
	    $hasLeaveError = true;
    
	    if( 'CSR' == $inputs['leave']['leave_type'] )
	    {
	      $csrs = $inputs['csr'];
	
	      foreach($csrs as $key=>$csr)
	      {
		$csr_slots[$key]['from_time'] = sprintf("%02s", $csr['from']['hour']).':' . sprintf("%02s", $csr['from']['min']);
		$csr_slots[$key]['to_time'] = sprintf("%02s", $csr['to']['hour']) . ':' . sprintf("%02s", $csr['to']['min']);
		$validator_csr[$key] = Validator::make($csr_slots[$key], Csr::$rules);
		
		if($validator_csr[$key]->fails())
		  $hasCsrError = true;
	      }
	    }
    
	    // check if user has selected any approver or not
	    if(!array_key_exists('approval', $inputs))
	      $hasApprovalError = true;
      
    
	    if($hasLeaveError || $hasApprovalError || $hasCsrError)
	    {
	      $validator = ($hasLeaveError)? $validator_leave->messages()->toArray() : [];
	      $validator = array_merge($validator, ($hasApprovalError)? ['approval' => ['Please select at least one approval']] : [] );
	      foreach($validator_csr as $vc)
	      {
		$validator = array_merge($validator, ($hasCsrError)? $vc->messages()->toArray() : [] );
	      }
	      return Redirect::back()->withErrors($validator)->withInput();
	    }
	    
	    $leave = array_merge($leave, ['user_id' => Auth::user()->id]);
	    $leave = Leave::create($leave);
	    
	    if( 'CSR' == $inputs['leave']['leave_type'] )
	    {
	      foreach($csr_slots as $slot)
	      {
		  $slot['leave_id'] = $leave->id;
		  Csr::create($slot);
	      }
	    }
	    $approvals = $inputs['approval'];
	    
	    foreach($approvals as $approval)
	    {
		$approval['leave_id'] = $leave->id;
		$approval['approved'] = 'PENDING';
		Approval::create($approval);
	    }
	    return Redirect::route('leaves.index')
		  ->with('message', 'Leave successfully applied');;
	}

	/**
	Function Name	: 		show
	Author Name		:		Jack Braj
	Date			:		June 02, 2014
	Parameters		:	    id
	Purpose			:		This function used to show individual leave
	*/
	
	public function show($id)
	{
	  $leave = Leave::findOrFail($id);
  
	  return View::make('leaves.show', compact('leave'));
	}

	/**
	Function Name		: 		edit
	Author Name		:		Jack Braj
	Date			:		June 02, 2014
	Parameters		:	    	id
	Purpose			:		This function used to render edit form with user information filled in
	*/
	
	public function edit($id)
	{
		$leave = Leave::find($id);

		return View::make('leaves.edit', compact('leave'));
	}

	/**
	Function Name	: 			update
	Author Name		:		Jack Braj
	Date			:		June 02, 2014
	Parameters		:	    	id
	Purpose			:		This function used to update individual leave
	*/
	
	public function update($id)
	{
		$leave = Leave::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Leave::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$leave->update($data);

		return Redirect::route('leaves.index');
	}

	/**
    Function Name	: 		destroy
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    id
    Purpose			:		This function used to delete a single leave
	*/
	
	public function destroy($id)
	{
		Leave::destroy($id);

		return Redirect::route('leaves.index');
	}
	
	
	/**
	Function Name		: 		myLeaves
	Author Name		:		Jack Braj
	Date			:		June 03, 2014
	Parameters		:	    	none
	Purpose			:		This function is used for listing all leaves/csrs
	*/
	
	public function myLeaves(){
		/* $myLeaves = Leave::where("user_id",Auth::user()->id)->get();
		return View::make('leaves.myleaves')->with("leaves",$myLeaves); */
		$leaves = Leave::where('user_id', '=', Auth::user()->id)->get();
		return View::make('leaves.myleaves')->with('leaves', $leaves);
		
	}
	
	
	/**
	Function Name		: 		leaveRequests
	Author Name		:		Jack Braj
	Date			:		June 03, 2014
	Parameters		:	    	none
	Purpose			:		This function is used for listing all leaves/csrs
	*/
	
	public function leaveRequests(){
		$leaveRequests = Approval::where("approver_id",Auth::user()->id)->get();
		return View::make('leaves.leaverequests')->with("leaveRequests",$leaveRequests);
		
	}
	

}
