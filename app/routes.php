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



Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/users/login', array('as' => 'userLogin', 'uses' => 'UsersController@login'));
Route::post('/users/login', array('as' => 'userLoginPost', 'uses' => 'UsersController@login'));
Route::get('/users/register', array('as' => 'userRegisteration', 'uses' => 'UsersController@register'));
Route::post('/users/register', array('as' => 'userRegisterationPost', 'uses' => 'UsersController@register'));
Route::get('/users/logout', array('as' => 'userLogout', 'uses' => 'UsersController@logout'));

// Leave Routes
Route::resource('/leaves', 'LeavesController');
Route::resource('/users', 'UsersController');

