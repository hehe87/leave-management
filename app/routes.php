<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/logingoogle',array("as" => "logingoogle", "uses" => 'UsersController@loginWithGoogle'));

//  SSL workaround for IRON MQ
Route::get('/test', array('as' => 'test', 'uses' => 'UsersController@test'));
Route::get('/logingoogle', 'UsersController@loginWithGoogle');
Route::get('/login', array('as' => 'userLogin', 'uses' => 'UsersController@getLogin'));
Route::post('/login', array('as' => 'userLoginPost', 'uses' => 'UsersController@postLogin'));
Route::get('/logout', array('as' => 'userLogout', 'uses' => 'UsersController@logout'));
Route::get('/password/forgot', array('as' => 'userForgotPassword', 'uses' => 'UsersController@getForgotPassword'));
Route::post('/password/forgot', array('as' => 'postUserForgotPassword', 'uses' => 'UsersController@postForgotPassword'));
Route::get('/password/change/{token}', array('as' => 'userChangePassword', 'uses' => 'UsersController@getChangePassword'));
Route::post('/password/change/{token}', array('as' => 'postUserChangePassword', 'uses' => 'UsersController@postChangePassword'));

Route::group(array('before' => 'admin_added_or_admin_auth'),function(){

	Route::get('/users/create', array('as' => 'userCreate', 'uses' => 'UsersController@create'));
	Route::post('/users/store', array('as' => 'userStore', 'uses' => 'UsersController@store'));
});

Route::group(array('before' => 'auth.admin'), function(){
	Route::get('/users/edit/{resource}', array('as' => 'userEdit', 'uses' => 'UsersController@edit'));
	Route::post('/users/update/{resource}', array('as' => 'userUpdate', 'uses' => 'UsersController@update'));
	Route::get('/users/remove/{resource}', array('as' => 'userRemove', 'uses' => 'UsersController@destroy'));
	Route::post('/users/destroy/{id}', array('as' => 'userDestroy', 'uses' => 'UsersController@destroy'));
	Route::get('/users', array('as' => 'usersListing', 'uses' => 'UsersController@index'));
	Route::post('/users/search', array('as' => 'usersSearch', 'uses' => 'UsersController@postSearch'));


	Route::get('/holidays/create', array('as' => 'holidayCreate', 'uses' => 'HolidaysController@create'));
	Route::post('/holidays/store', array('as' => 'holidayStore', 'uses' => 'HolidaysController@store'));
	Route::get('/holidays/edit/{resource}', array('as' => 'holidayEdit', 'uses' => 'HolidaysController@edit'));
	Route::post('/holidays/update/{resource}', array('as' => 'holidayUpdate', 'uses' => 'HolidaysController@update'));
	Route::post('/holidays/destroy/{id}', array('as' => 'holidayDestroy', 'uses' => 'HolidaysController@destroy'));
	Route::get('/holidays', array('as' => 'holidaysListing', 'uses' => 'HolidaysController@index'));
	Route::get('/leaves', array('as' => 'leaves.index', 'uses' => 'LeavesController@index'));
	Route::get('/leaves/report', array('as' => 'leaves.report', 'uses' => 'LeavesController@getReport'));
	Route::get('/leaves/report/general', array('as' => 'leaves.general_report', 'uses' => 'LeavesController@generalReport'));
	Route::post('/leaves/report/general', array('as' => 'leaves.post_general_report', 'uses' => 'LeavesController@fetchGeneralReport'));
	//Route::post('/leaves/report/generate', array('as' => 'leaves.generateReport', 'uses' => 'LeavesController@generateReport'));
	Route::get('/leaves/pending', array('as' => 'leaves.pendingLeaves', 'uses' => 'LeavesController@pendingLeaves'));
	Route::get('/settings', array('as' => 'users.settings', 'uses' => 'UsersController@getSettings'));
	Route::post('/settings', array('as' => 'users.postSettings', 'uses' => 'UsersController@postSettings'));
	Route::post('/users/getextraleaves', array('as' => 'users.getExtraLeaves', 'uses' => 'UsersController@getExtraLeaves'));
});

Route::group(array('before' => 'auth'),function(){
	Route::get('/leaves/create', array('as' => 'leaves.create', 'uses' => 'LeavesController@create'));
	Route::post('/leaves/store', array('as' => 'leaves.store', 'uses' => 'LeavesController@store'));
	Route::get('/leaves/{id}/remove', array('as' => 'leaves.destroy', 'uses' => 'LeavesController@destroy'));
	Route::post('leaves/approve',array('as' => 'approval.updateStatus', 'uses' => 'ApprovalController@updateStatus'));
});

Route::get('/editable/save', array('as' => 'base.saveEditable', 'uses' => 'BaseController@saveEditable'));



Route::group(array('before' => 'auth.user'),function(){

	View::composer('layouts.user_layout', function($view)
	{
		$empId = Auth::user()->id;
		$pendingRequests = Approval::where("approver_id", $empId)->where("approved", "PENDING")->count();
		$view->with('pendingRequests', $pendingRequests);
	});

	Route::get('/', array('as' => 'usersHome', 'uses' => 'HomeController@userDashboard'));



	// Leave Routes
	Route::get('/leaves/search', 'LeavesController@search');
	Route::get('/leaves/myleaves', array('as' => 'myLeaves', 'uses' => 'LeavesController@myLeaves'));
	Route::get('/leaves/requests', array('as' => 'leaveRequests', 'uses' => 'LeavesController@leaveRequests'));



	Route::group(array('before' => 'leaves.editable'), function(){
		Route::get('/leaves/{id}/edit', array('as' => 'leaves.edit', 'uses' => 'LeavesController@edit'));
		Route::post('/leaves/{id}/update', array('as' => 'leaves.update', 'uses' => 'LeavesController@update'));
		Route::post('/leaves/{id}/remove', array('as' => 'leaves.destroy', 'uses' => 'LeavesController@destroy'));
	});

	//Route::get('/leaves/{id}/edit', array('as' => 'leaves.edit', 'uses' => 'LeavesController@edit'));
	//Route::post('/leaves/{id}/update', array('as' => 'leaves.update', 'uses' => 'LeavesController@update'));
	//Route::post('/leaves/{id}/remove', array('as' => 'leaves.destroy', 'uses' => 'LeavesController@destroy'));
	// Route::get('/leaves/create', array('as' => 'leaves.create', 'uses' => 'LeavesController@create'));
	// Route::post('/leaves/store', array('as' => 'leaves.store', 'uses' => 'LeavesController@store'));
});


Route::get('leaves/{resource}/approvals', array('as' => 'approval.leaveApprovals', 'uses' => 'ApprovalController@leaveApprovals'));


Route::get('leaves/new/add', array('as' => 'leaves.getAddLeave', 'uses' => 'LeavesController@getAddLeave'));
Route::get('leaves/new/{resource}/edit', array('as' => 'leaves.getEditLeave', 'uses' => 'LeavesController@getEditLeave'));
Route::get('csr/new/add', array('as' => 'leaves.getAddCSR', 'uses' => 'LeavesController@getAddCSR'));
Route::get('csr/new/{resource}/edit', array('as' => 'leaves.getEditCSR', 'uses' => 'LeavesController@getEditCSR'));
Route::post('leaves/new/store', array('as' => 'leaves.postAddLeave', 'uses' => 'LeavesController@postAddLeave'));
Route::post('leaves/new/{resource}/update', array('as' => 'leaves.postEditLeave', 'uses' => 'LeavesController@postEditLeave'));
Route::post('csr/new/store', array('as' => 'leaves.postAddCSR', 'uses' => 'LeavesController@postAddCSR'));
Route::post('csr/new/{resource}/update', array('as' => 'leaves.postEditCSR', 'uses' => 'LeavesController@postEditCSR'));
