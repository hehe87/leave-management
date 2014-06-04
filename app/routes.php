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



Route::get('/', array('as' => 'usersHome', 'uses' => 'HomeController@showWelcome'));

Route::get('/users/login', array('as' => 'userLogin', 'uses' => 'UsersController@login'));
Route::post('/users/login', array('as' => 'userLoginPost', 'uses' => 'UsersController@login'));
Route::get('/users/register', array('as' => 'userRegisteration', 'uses' => 'UsersController@register'));
Route::post('/users/register', array('as' => 'userRegisterationPost', 'uses' => 'UsersController@register'));
Route::get('/users/logout', array('as' => 'userLogout', 'uses' => 'UsersController@logout'));


// Leave Routes
Route::get('/leaves/search', 'LeaveController@search');
Route::resource('/leaves', 'LeaveController');
Route::resource('/users', 'UsersController');

Route::get('/pending-requests', 'ApprovalController@pending');
Route::get('/my-leaves', 'LeaveController@userLeaves');
Route::post('/update-status', 'ApprovalController@updateStatus');
Route::get('/users', array('as' => 'usersListing', 'uses' => 'UsersController@index'));

Route::get('/holidays/create', array('as' => 'holidayCreate', 'uses' => 'HolidaysController@create'));
Route::post('/holidays/store', array('as' => 'holidayStore', 'uses' => 'HolidaysController@store'));

Route::get('/holidays', array('as' => 'holidaysListing', 'uses' => 'HolidaysController@index'));


