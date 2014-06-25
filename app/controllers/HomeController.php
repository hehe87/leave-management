<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function userDashboard()
	{
		$user = Auth::user();
		$totalLeaves = $user->getTotalLeaves();
		$approvedLeaves = count($user->approvedLeaves(date("Y")));
		$pendingLeaves = count($user->pendingLeaves(date("Y")));
		$rejectedLeaves = count($user->rejectedLeaves(date("Y")));
		$extraLeaves = count($user->extraLeaves(date("Y")));
		$appliedLeaves = count($user->appliedLeaves(date("Y")));

		return View::make("users.user_dashboard")
		->with("total_leaves", $totalLeaves)
		->with("approved_leaves", $approvedLeaves)
		->with("pending_leaves", $pendingLeaves)
		->with("extra_leaves", $extraLeaves)
		->with("applied_leaves", $appliedLeaves);
	}

}
