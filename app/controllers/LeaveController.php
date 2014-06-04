<?php
/**
  Class Name					:	LeaveController
  author 						:	Jack Braj
  Date							:	June 02, 2014
  Purpose						:	Resourceful controller for leaves
  Table referred				:	leaves, users, approvals
  Table updated					:	leaves, approvals
  Most Important Related Files	:   /app/controllers/LeaveController.php
*/


class LeaveController extends \BaseController {

	/**
    Function Name	: 		index
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    none
    Purpose			:		This function used to list all leaves
	*/

	public function __construct()
	{
		$this->beforeFilter('auth');
	}
	
	
	public function index()
	{
		$leaves = Leave::all();

		return View::make('leaves.index', compact('leaves'));
	}

	/**
    Function Name	: 		create
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    none
    Purpose			:		This function renders leave form with user data
	*/
	
	public function create()
	{
		$users = User::where('id', '<>', Auth::user()->id)->lists('name', 'id');
		return View::make('leaves.create')->with('users', $users);
	}

	/**
    Function Name	: 		store
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    none
    Purpose			:		This function used to create leave
	*/
	
	public function store()
	{
		$validator = Validator::make($data = Input::except('_token'), Leave::$rules);
		
		if( Input::get('leave_type') == 'CSR' )
		{
			foreach( Input::get('from_hour') as $key => $from_h )
			{
			// add time rules to validation array if leave type is CSR
			$validator->sometimes( array("from_hour[$key]","to_hour[$key]") , 'between:0,24', function($input)
			{
				return ('CSR' == $input->leave_type);
			});
			
			$validator->sometimes( array("from_min[$key]", "to_min[$key]"), 'between:0,59', function($input)
			{
				return ('CSR' == $input->leave_type);
			});
				
			}
		}
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$inputs = Leave::normalizeInput(Input::all());
		
		// Save each leave and related approval record
		foreach($inputs as $input)
		{
			$leave = Leave::create($input);
			// Insert related approval record
			foreach($input['approver_id'] as $approver)
			{
				Approval::create(['approver_id' => $approver, 'leave_id' => $leave->id,  'approval_note' => '']);
			}
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
    Function Name	: 		edit
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    id
    Purpose			:		This function used to render edit form with user information filled in
	*/
	
	public function edit($id)
	{
		$leave = Leave::find($id);

		return View::make('leaves.edit', compact('leave'));
	}

	/**
    Function Name	: 		update
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    id
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
    Function Name	: 		userLeaves
    Author Name		:		Jack Braj
    Date			:		June 04, 2014
    Parameters		:	    none
    Purpose			:		This function used to display a logged in user's leaves
	*/
	
	public function userLeaves()
	{
		$leaves = Leave::where('user_id', '=', Auth::user()->id)->get();
		return View::make('leaves.leaves')
					->with('leaves', $leaves);
	}
	

}
