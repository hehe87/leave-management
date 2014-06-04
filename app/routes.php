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
Route::get('/users/create', array('as' => 'userCreate', 'uses' => 'UsersController@create'));
Route::post('/users/store', array('as' => 'userStore', 'uses' => 'UsersController@store'));
Route::get('/users/edit/{resource}', array('as' => 'userEdit', 'uses' => 'UsersController@edit'));
Route::post('/users/update/{resource}', array('as' => 'userUpdate', 'uses' => 'UsersController@update'));
Route::get('/users/remove/{resource}', array('as' => 'userRemove', 'uses' => 'UsersController@destroy'));
Route::get('/users/logout', array('as' => 'userLogout', 'uses' => 'UsersController@logout'));
Route::get('/users/password/forgot', array('as' => 'userForgotPassword', 'uses' => 'UsersController@getForgotPassword'));
Route::post('/users/password/forgot', array('as' => 'postUserForgotPassword', 'uses' => 'UsersController@postForgotPassword'));
Route::get('/users/password/change/{token}', array('as' => 'userChangePassword', 'uses' => 'UsersController@getChangePassword'));
Route::post('/users/password/change/{token}', array('as' => 'postUserChangePassword', 'uses' => 'UsersController@postChangePassword'));

Route::get('/users', array('as' => 'usersListing', 'uses' => 'UsersController@index'));
Route::post('/users/search', array('as' => 'usersSearch', 'uses' => 'UsersController@postSearch'));


Route::get('/holidays/create', array('as' => 'holidayCreate', 'uses' => 'HolidaysController@create'));
Route::post('/holidays/store', array('as' => 'holidayStore', 'uses' => 'HolidaysController@store'));
Route::get('/holidays/edit/{resource}', array('as' => 'holidayEdit', 'uses' => 'HolidaysController@edit'));
Route::post('/holidays/update/{resource}', array('as' => 'holidayUpdate', 'uses' => 'HolidaysController@update'));

Route::get('/holidays', array('as' => 'holidaysListing', 'uses' => 'HolidaysController@index'));

