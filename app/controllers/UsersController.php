<?php
/**
  Class Name:                       UserController
  author :		            Nicolas Naresh
  Date:			            May, 30 2014
  Purpose:		            This class acts as a controller for user management
  Table referred:		    users
  Table updated:	            users
  Most Important Related Files:     models/User.php
*/

class UsersController extends \BaseController {

  /**
    Function Name: 		login
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	username, password
    Purpose:			This function acts as login action which on GET request displays user
                                with login form and with POST request authenticates the credentials
  */
  public function login(){
    if(Auth::check()){
      return Redirect::to("/");
    }
    if(Request::isMethod('post')){
      $formData = Input::all();
      $email = $formData["email"];
      $password = $formData["password"];
      $rememberMe = false;
      if(key_exists("rememberMe",$formData)){
	$rememberMe = true;
      }
      if (Auth::attempt(array('email' => $email, 'password' => $password), $rememberMe))
      {
	return Redirect::to("/");
      }
      else{
	return Redirect::to("users/login")->with('error', 'Email or Password does not match');
      }
    }
    else{
      return View::make('users.login');
    }
  }
  
  /**
    Function Name: 		logout
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	username, password
    Purpose:			This function acts as logout action which logouts the currently logged in user
  */
  public function logout(){
    Auth::logout();
    return Redirect::to("users/login")->with('message', 'Your are now logged out!');
  }
  
  
  /**
    Function Name: 		login
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	username, password
    Purpose:			This function acts as user registration action which on GET request displays user
                                with registration form and with POST request registers a new user to the system.
  */
  public function register(){
    if(Auth::check()){
      return Redirect::to("/");
    }
    if(Request::isMethod('post')){
      $formData = Input::all();
      $validator = User::validateRegistrationForm($formData);
      if($validator->fails())
      {
	return Redirect::to('users/register')->withErrors($validator)->withInput()->with('success', 'Your account has been created successfully, Please login now!');
      }
      else{
	$formData = Input::except("password_confirmation","_token");
	$formData["password"] = Hash::make($formData["password"]);
	User::create($formData);
	return Redirect::to('users/login');
      }
      
	
    }
    else{
      return View::make('users.register');
    }
  }
  
  
  /**
   * Display a listing of users
   *
   * @return Response
   */
  public function index()
  {
    $users = User::all();
    return View::make('users.index', compact('users'));
  }

  /**
   * Show the form for creating a new user
   *
   * @return Response
   */
  public function create()
  {
    return View::make('users.create');
  }

  /**
   * Store a newly created user in storage.
   *
   * @return Response
   */
  public function store()
  {
    $validator = Validator::make($data = Input::all(), User::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    User::create($data);

    return Redirect::route('users.index');
  }

  /**
   * Display the specified user.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);

    return View::make('users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified user.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);

    return View::make('users.edit', compact('user'));
  }

  /**
   * Update the specified user in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $user = User::findOrFail($id);

    $validator = Validator::make($data = Input::all(), User::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    $user->update($data);

    return Redirect::route('users.index');
  }

  /**
   * Remove the specified user from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    User::destroy($id);

    return Redirect::route('users.index');
  }

}
