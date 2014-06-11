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
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}([,][\d]{4}-[\d]{2}-[\d]{2})+/', function($input){
	    return $input->leave_type === "MULTI";
	  });
	  
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}([,][\d]{4}-[\d]{2}-[\d]{2})/', function($input){
	    return $input->leave_type === "LONG";
	  });
	  
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}/', function($input){
	    $ltypes = array('FH','SH','LEAVE','CSR');
	    return in_array($input->leave_type, $ltypes);
	  });
    
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
	  $tempLeave = $leave;
    
	  $addedLeaves = [];
	  
	  
	  // grab all leave dates in an array
	  $leave_dates = explode(",", $leave['leave_date']);
		
	  
	  if($tempLeave["leave_type"] == "MULTI"){
	    foreach($leave_dates as $leave_date){
	      $leave = $tempLeave;
	      $leave["leave_date"] = $leave_date;
	      $leave["leave_type"] = "LEAVE";
	      $leave = array_merge($leave, ['user_id' => Auth::user()->id]);
	      $leave = Leave::create($leave);
	      $addedLeaves[] = $leave;
	    }
	  }
	  else{
	    if($tempLeave["leave_type"] == "LONG"){
	      $leave = $tempLeave;
	      $leave["leave_date"] = $leave_dates[0];
	      $leave["leave_to"] = $leave_dates[1];
	      $leave = array_merge($leave, ['user_id' => Auth::user()->id]);
	      $leave = Leave::create($leave);
	      $addedLeaves[] = $leave;
	    }
	    else{
	      $leave = $tempLeave;
	      $leave["leave_date"] = $leave_dates[0];
	      $leave = array_merge($leave, ['user_id' => Auth::user()->id]);
	      $leave = Leave::create($leave);
	      $addedLeaves[] = $leave;
	      
	    }
	  }
	  
		if( 'CSR' == $inputs['leave']['leave_type'] )
	  {
	    foreach($csr_slots as $slot)
	    {
	      $slot['leave_id'] = $addedLeaves[0]->id;
	      Csr::create($slot);
	    }
	  }
		
		
	  $approvals = $inputs['approval'];
	  foreach($addedLeaves as $addedLeave){
	    foreach($approvals as $approval)
	    {
	      $approval['leave_id'] = $addedLeave->id;
	      $approval['approved'] = 'PENDING';
	      Approval::create($approval);
	    }
	  }	    
	  return Redirect::to(URL::route('myLeaves'))
		->with('message', 'Leave successfully applied');
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
	  if( 'LONG' == $leave->leave_type ) {
	    $leave->leave_date .= ','. $leave->leave_to;      
	  }
	  $users = User::where('id', '<>', Auth::user()->id)->lists('name', 'id');
	  $inputCSRs = array();
	  if($leave->leave_type == "CSR"){
	    $csrs = $leave->csrs;
	    foreach($csrs as $csr){
	      $from_time = new DateTime($csr->from_time);
	      $to_time = new DateTime($csr->to_time);
	      $from_hour = $from_time->format("h");
	      $from_min = $from_time->format("i");
	      $to_hour = $to_time->format("h");
	      $to_min = $to_time->format("i");
	      $inputCSRs[] = array("from" => array("hour" => $from_hour, "min" => $from_min), "to" => array("hour" => $to_hour, "min" => $to_min));
	    }
	  }
	  //$this->pre_print($inputCSRs);
	  return View::make('leaves.edit', array('leave' => $leave, 'users' => $users, 'inputCSRs' => $inputCSRs));
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
	  $validator = [];
	  $validator_leave = [];
	  $validator_csr = [];
	  $inputs = Input::all();
	  $leave = $inputs['leave'];
	  $hasLeaveError = false;
	  $hasApprovalError = false;
	  $hasCsrError = false;
	  $validator_leave = Validator::make($leave, Leave::$rules);
	  
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}([,][\d]{4}-[\d]{2}-[\d]{2})+/', function($input){
	    return $input->leave_type === "MULTI";
	  });
	  
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}([,][\d]{4}-[\d]{2}-[\d]{2})/', function($input){
	    return $input->leave_type === "LONG";
	  });
	  
	  $validator_leave->sometimes('leave_date', 'regex:/[\d]{4}-[\d]{2}-[\d]{2}/', function($input){
	    $ltypes = array('FH','SH','LEAVE','CSR');
	    return in_array($input->leave_type, $ltypes);
	  });
	  
    
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
	  $leaveObj = Leave::findOrFail($id);
	  
	  if($leaveObj->leave_type === "LONG" || $leave["leave_type"] === "LONG"){
	    $ldates = explode(",",$leave["leave_date"]);
	    $leave_date = $ldates[0];
	    $leave_to = $ldates[1];
	    $leave["leave_date"] = $leave_date;
	    $leave["leave_to"] = $leave_to;
	  }
	  
	  
	  $leaveObj->update($leave);
	  //$leave = Leave::create($leave);
	  
	  if( 'CSR' == $inputs['leave']['leave_type'] )
	  {
	    $leaveObj->csrs()->forceDelete();
	    foreach($csr_slots as $slot)
	    {
		$slot['leave_id'] = $leaveObj->id;
		Csr::create($slot);
	    }
	  }
	  $approvals = $inputs['approval'];
	  
	  $leaveObj->approvals()->forceDelete();
	  foreach($approvals as $approval)
	  {
	    $approval['leave_id'] = $leaveObj->id;
	    $approval['approved'] = 'PENDING';
	    Approval::create($approval);
	  }
	  return Redirect::to(URL::route('myLeaves'))
		->with('message', 'Leave successfully applied');
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
	  $leave = Leave::find($id);
	  $leave->approvals()->forceDelete();
	  if($leave->leave_type == "CSR"){
	    $leave->csrs()->forceDelete();
	  }
	  Leave::destroy($id);
	  return Response::json(array('status' => true));
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
	
	
	
	public function getReport(){
	  $searchData = Input::all();
	  $leaves = null;
	  if(!empty($searchData)){
	    $user = User::where("name", $searchData["employee_name"])->get()->first();
	    $leaveType = $searchData["leave_type"];
	    switch($searchData['date_option']){
	      case "between-dates":
		$leaves = Leave::where("user_id", $user->id)
		->whereBetween("leave_date", array($searchData["from_date"], $searchData["to_date"]))
		->where("leave_type", $leaveType)
		->get();
		break;
	      case "by-date":
		$leaves = Leave::where("user_id", $user->id)
		->where("leave_date", $searchData["on_date"])
		->where("leave_type", $leaveType)
		->get();
		break;
	      case "by-year":
		$leaves = Leave::where("user_id", $user->id)
		->where(DB::raw("YEAR(leave_date)"), $searchData["year"])
		->where("leave_type", $leaveType)
		->get();
		break;
	      case "by-month":
		$leaves = Leave::where("user_id", $user->id)
		->where(DB::raw("YEAR(leave_date)"), date("Y"))
		->where(DB::raw("MONTH(leave_date)"), date("m"))
		->where("leave_type", $leaveType)
		->get();
		break;
	    }
	  }
	  
	  return View::make('leaves.report')->withInputs($searchData)->with("leaves",$leaves);
	}
	
	public function generateReport(){
	  
	}
	
	
	
}
