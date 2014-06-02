<?php
/**
  Class Name					:	LeavesController
  author 						:	Jack Braj
  Date							:	June 02, 2014
  Purpose						:	Resourceful controller for leaves
  Table referred				:	leaves, users, approvals
  Table updated					:	leaves, approvals
  Most Important Related Files	:   /app/controllers/LeaveController.php
*/

class LeavesController extends \BaseController {

	/**
    Function Name	: 		index
    Author Name		:		Jack Braj
    Date			:		June 02, 2014
    Parameters		:	    none
    Purpose			:		This function used to list all leaves
	*/
	
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
		
		// add time rules to validation array if leave type is CSR
		$validator->sometimes( array('from_time','to_time'), 'required', function($input)
		{
			return ('CSR' == $input->leave_type);
		});
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Leave::create($data);

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

}
