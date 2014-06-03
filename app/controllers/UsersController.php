<?php
/**
  Class Name:                       UsersController
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
      return Redirect::to(URL::route('usersHome'));
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
	$employeeType = Auth::user()->employeeType;
	if($employeeType === "EMPLOYEE"){
	  return Redirect::to(URL::route('usersHome'));
	}
	else{
	  return Redirect::to(URL::route('usersListing'));
	}
	
      }
      else{
	return Redirect::to(URL::route('userLogin'))->with('error', 'Email or Password does not match');
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
    return Redirect::to(URL::route('userLogin'))->with('message', 'Your are now logged out!');
  }
  
  
  /**
    Function Name: 		postSearch
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function searches for the name of user in database and returns an array of
				matching users.
  */

  public function postSearch(){
    $users = User::where("name","LIKE", "%". Input::get("name") . "%")->get();
    return View::make('users.listing')->with("users", $users);
  }
  
  
  /**
    Function Name: 		index
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying all the users in a table
  */
  public function index()
  {
    $users = User::all();
    return View::make('users.index', compact('users'));
  }

  /**
    Function Name: 		create
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying user addition form
  */
  public function create()
  {
    $user = new User();
    return View::make('users.create')->with("user",$user);
  }

  /**
    Function Name: 		store
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for storing the filled information about
				user to the database table users
  */
  public function store()
  {
    $formData = Input::all();
    $validator = User::validateRegistrationForm($formData);
    if($validator->fails())
    {
      return Redirect::to(URL::route('userCreate'))->withErrors($validator)->withInput();
    }
    else{
      $formData = Input::except("password_confirmation","_token");
      $formData["password"] = Hash::make($formData["password"]);
      $user = User::create($formData);
      $user->totalLeaves = $user->getTotalLeaves();
      $user->save();
      return Redirect::to(URL::route('usersListing'))->with('success', 'Your account has been created successfully, Please login now!');
    }
  }

  /**
    Function Name: 		edit
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying edit user form, where the
				retlated to the user can be edited
  */
  public function edit($id)
  {
    $user = User::find($id);
    return View::make('users.edit')->with("user", $user);
  }

  /**
    Function Name: 		edit
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function updates the given users information to database with
				the information updated in the edit form
  */
  public function update($id)
  {
    $formData = Input::all();
    $validator = User::validateRegistrationForm($formData, false);
    if($validator->fails())
    {
      return Redirect::to(URL::route('userEdit',array("id" => $id)))->withErrors($validator)->withInput();
    }
    else{
      $formData = Input::except("password_confirmation","_token");
      if(!empty($formData["password"])){
	$formData["password"] = Hash::make($formData["password"]);
      }
      else{
	unset($formData["password"]);
      }
      
      
      $user = User::find($id);
      $user->update($formData);
      $user->totalLeaves = $user->getTotalLeaves();
      $user->save();
      return Redirect::to(URL::route('usersListing'))->with('success', 'Your account has been created successfully, Please login now!');
    }
  }

  /**
    Function Name: 		destroy
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function removes the specified user from database
  */
  public function destroy($id)
  {
    User::destroy($id);
    return Redirect::to(URL::route('usersListing'));
  }

}
