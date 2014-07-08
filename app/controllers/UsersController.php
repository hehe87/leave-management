<?php
/*
  Class Name:                       UsersController
  author :		            Nicolas Naresh
  Date:			            May, 30 2014
  Purpose:		            This class acts as a controller for user management
  Table referred:		    users
  Table updated:	            users
  Most Important Related Files:     models/User.php
*/

class UsersController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth', array(
      	'except' => array(
          'test',
      	  'getLogin',
      	  'postLogin',
          'create',
          'store',
      	  'getForgotPassword',
      	  'postForgotPassword',
      	  'getChangePassword',
      	  'postChangePassword'
      	)
      )
    );
  }


  public function test(){
    return View::make("users.test");
  }

  /*
    Function Name: 		getLogin
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	username, password
    Purpose:			This function acts as login action which displays user
                                with login form.
  */
  public function getLogin(){
    if(Auth::check()){
      if(Auth::user()->employeeType == "ADMIN"){
        return Redirect::to(URL::route('usersHome'));
      }
      else{
        return Redirect::to(URL::route('myLeaves'));
      }
    }
    return View::make('users.login');
  }

  /*
    Function Name: 		postLogin
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	  username, password
    Purpose:			This function acts as login action which displays user
    with login form.
  */
  public function postLogin(){
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
	      return Redirect::intended(URL::route('usersHome'));
      }
      else{
	      return Redirect::intended(URL::route('usersListing'));
      }

    }
    else{
      return Redirect::to(URL::route('userLogin'))->with('error', 'Email or Password does not match');
    }
  }




  /*
    Function Name: 		logout
    Author Name:		  Nicolas Naresh
    Date:			        June, 02 2014
    Parameters:	      username, password
    Purpose:			    This function acts as logout action which logouts the currently logged in user
  */
  public function logout(){
    Auth::logout();
    return Redirect::to(URL::route('userLogin'))->with('message', 'Your are now logged out!');
  }



  /*
    Function Name: 		getForgotPassword
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	-
    Purpose:			This function displays forgot password page
  */
  public function getForgotPassword(){
    return View::make('users.forgotpassword');
  }


  /*
    Function Name: 		postForgotPassword
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	-
    Purpose:			This function emails a link to input email id with a change password link
  */
  public function postForgotPassword(){
    $email = Input::get("email");
    $validator = Validator::make(
      array("email" => $email),
      array("email" => "required|email")
    );

    if($validator->fails()){
      return Redirect::to(URL::route("userForgotPassword"))->with('error', 'Email Address is not valid');
    }
    else{
      $user = User::where("email", $email)->get();
      if($user->first()){
      	$user = $user->first();
      	$userName = $user->name;
      }
      else{
        return Redirect::to(URL::route("userForgotPassword"))->with('error', 'Account not found for this Email');
      }

      $token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 100);

      $emailSubject = "Leave Management: Change Your Password";

      $data = array(
      	'token' => $token,
      	'userName' => $userName,
      	'email' => $email
      );
      Mail::send('emails.changepassword', $data, function($message) use ($email,$userName, $emailSubject, $user, $token)
      {
      	$message->to($email, $userName)->from('nicolas.naresh@ithands.net', 'Admin')->subject($emailSubject);
      	$user->changePasswordToken = $token;
      	$user->save();
      });
      return Redirect::to(URL::route("userLogin"))->with("success","An Email has been sent to your email id for change password instructions!");
    }
  }


  /*
    Function Name: 		getChangePassword
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	$token - change password token generated at time of submitting forgot password page
    Purpose:			This function provides a change password form to user
  */
  public function getChangePassword($token){

    $user = User::where("changePasswordToken",$token)->get();
    if($user->first()){
      $user = $user->first();
      return View::make("users.changepassword")->with("token",$token);
    }
    else{
      return Redirect::to(URL::route("userLogin"))->with("error","The link you requested is no longer valid!");
    }
  }


  /*
    Function Name: 		postChangePassword
    Author Name:		Nicolas Naresh
    Date:			June, 02 2014
    Parameters:	            	$token - change password token generated at time of submitting forgot password page
    Purpose:			This function updates user password
  */
  public function postChangePassword($token){
    $validator = Validator::make(
      Input::except("_token"),
      array(
      	'password'  =>'required|between:4,8|confirmed',
      	'password_confirmation'=>'required|between:4,8',
      )
    );
    if($validator->fails()){
      return Redirect::to(URL::route("userChangePassword",array("token" => $token)))->withErrors($validator)->withInput()->with("error", "This form contains errors, please review and try again");
    }
    else{
      $user = User::where("changePasswordToken",$token);
      if(!$user->first()){
	       return Redirect::to(URL::route("userLogin"))->with("error","The link you requested is no longer valid!");
      }
      $user = $user->first();
      $user->password = Hash::make(Input::get("password"));
      $user->changePasswordToken = "";
      $user->save();
      return Redirect::to(URL::route("userLogin"))->with("success","Your password has been updated successfully!");
    }
  }



  /*
    Function Name: 		postSearch
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function searches for the name of user in database and returns an array of
				matching users.
  */

  public function postSearch(){

    if((Input::get("onblank") && Input::get("onblank") == "nil") && (trim((Input::get('name'))) == "")) {
      $searchFor = "%1234%";
    }
    else{
      $searchFor = "%". Input::get("name") . "%";
    }

    $users = User::where(DB::raw("lower(name)"),"LIKE", $searchFor)->get();

    return View::make(Input::get('view') ? 'users.' . Input::get('view') : 'users.listing')->with("users", $users);
  }


  /*
    Function Name: 		index
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying all the users in a table
  */
  public function index()
  {
    $users = User::orderBy("name")->get();
    return View::make('users.index', compact('users'));
  }

  /*
    Function Name: 		create
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying user addition form
  */
  public function create()
  {
    $user = new User();
    $user->employeeType = "EMPLOYEE";
    return View::make('users.create')->with("user",$user);
  }

  /*
    Function Name: 		store
    Author Name:		Jack Braj
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for storing the filled information about
				user to the database table users
  */
  public function store()
  {
    $formData = Input::except("_token");
    $formData['inTime'] = date('H:i:s', strtotime($formData['inTime']));
    $formData['outTime'] = date('H:i:s', strtotime($formData['outTime']));
    $validator = User::validateRegistrationForm($formData);
    if($validator->fails())
    {
      return Redirect::to(URL::route('userCreate'))->withErrors($validator)->withInput()->with("error", "This form contains errors, please review and try again");
    }
    else{
      $formData["doj"] = date("Y-m-d",strtotime($formData["doj"]));
      $formData["dob"] = date("Y-m-d",strtotime($formData["dob"]));
      $user = User::create($formData);
      $user->totalLeaves = $user->getTotalLeaves();

      // new code
      $token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 100);

      $emailSubject = "Leave Management: Your Account Details";

      $data = array(
        'token' => $token,
      );
      $data = array_merge($data,array('user'=> $user->toArray()));

      // Send an email to user
      Mail::queue('emails.registration', $data, function($message) use ($user, $token, $emailSubject)
      {
        $message->to($user->email, $user->name)->from('nicolas.naresh@ithands.net', 'Admin')->subject($emailSubject);
        $user->changePasswordToken = $token;
        $user->save();
      });

      return Redirect::to('users')->with('success', 'Account created successfully');
    }
  }

  /*
    Function Name: 		edit
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function acts as an action for displaying edit user form, where the
				retlated to the user can be edited
  */
  public function edit($id)
  {
    $user = User::find($id);
    $user->inTime = preg_replace("/:00$/", "", $user->inTime);
    $user->outTime = preg_replace("/:00$/", "", $user->outTime);
    return View::make('users.edit')->with("user", $user);
  }

  /*
    Function Name: 		update
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function updates the given users information to database with
				the information updated in the edit form
  */
  public function update($id)
  {
    $formData = Input::all();
    $formData['inTime'] = date('H:i:s', strtotime($formData['inTime']));
    $formData['outTime'] = date('H:i:s', strtotime($formData['outTime']));
    $validator = User::validateRegistrationForm($formData, $id);
    if($validator->fails())
    {
      return Redirect::to(URL::route('userEdit',array("id" => $id)))->withErrors($validator)->withInput()->with("error", "This form contains errors, please review and try again");
    }
    else{
      $formData = Input::except("password_confirmation","_token");
      $formData['inTime'] = date('H:i:s', strtotime($formData['inTime']));
      $formData['outTime'] = date('H:i:s', strtotime($formData['outTime']));
      $formData["doj"] = date("Y-m-d",strtotime($formData["doj"]));
      $formData["dob"] = date("Y-m-d",strtotime($formData["dob"]));
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
      return Redirect::to(URL::route('usersListing'))->with('success', 'Account has been updated successfully');
    }
  }

  /*
    Function Name: 		destroy
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function removes the specified user from database
  */
  public function destroy($id)
  {
    $leave_ids = Leave::where('user_id', '=', $id)->lists('id');

    if( count($leave_ids)>0 )
    {

      // Delete all approvals
      Approval::whereIn('leave_id', $leave_ids)->delete();

      // Delete all csrs
      Csr::whereIn('leave_id', $leave_ids)->delete();

      // Delete all leaves
      Leave::where('user_id', '=', $id)->delete();
    }

    // Delete the users
    User::destroy($id);
    return Response::json(array('status' => true));
  }


  /*
  Function Name:	getSettings
  Author Name:		Nicolas Naresh
  Date:			June, 10 2014
  Parameters:		-
  Purpose:		Display tabbed settings page for admin
  */

  public function getSettings(){
    //$this->pre_print(array_combine(range(1,31), array_map(function($d){return sprintf("%02s",$d); }, range(1,31))));
    $currYear = date("Y");
    $yearStart = YearStart::where("year", $currYear)->first();
    // $dayList = array_combine(array_merge(array("" => ""), range(1,31)), array_merge(array("" => "Select Day"),array_map(function($d){return sprintf("%02s",$d); }, range(1,31))));
    $dayList = TemplateFunction::getIntegerRangeDropdown(1,31);

    //$this->pre_print($dayList);
    //$monList = array_combine(array_merge(array("" => ""), range(1,12)), array_merge(array("" => "Select Month"),array_map(function($d){return sprintf("%02s",$d); }, range(1,12))));
    $monList = TemplateFunction::getIntegerRangeDropdown(1,12);
    if(!$yearStart){
      $yearStart = new YearStart();
    }
    $leaveConfig = array();
    $leaveConfig["carry_forward_leaves"] = Leaveconfig::getConfig("carry_forward_leaves",$currYear);
    $leaveConfig["paternity_leaves"] = Leaveconfig::getConfig("paternity_leaves",$currYear);
    $leaveConfig["maternity_leaves"] = Leaveconfig::getConfig("maternity_leaves",$currYear);
    $leaveConfig["paid_leaves"] = Leaveconfig::getConfig("paid_leaves",$currYear);

    return View::make("users.settings")->with("yearStart", $yearStart)->with("dayList", $dayList)->with("monList", $monList)->with("leaveConfig", $leaveConfig);
  }

  /*
  Function Name:	postSettings
  Author Name:		Nicolas Naresh
  Date:			June, 10 2014
  Parameters:		-
  Purpose:		Saves/Updates various setting values
  */

  public function postSettings(){

    $allSettings = Input::all();
    if(isset($allSettings['extra_leaves']['from_date'])){
      $allSettings['extra_leaves']['from_date'] = date("Y-m-d",strtotime($allSettings['extra_leaves']['from_date']));
    }
    if(key_exists("gapi",$allSettings)){
      $showTab = "#gapi";
      $validationRules = array(
      	'client_id' => array('required'),
      	'service_account_name'  =>'required',
      	'key_file_location' => 'required',
      	'timezone' => 'required',
      	'calendar_id' => 'required'
      );

      $validator = Validator::make(
      	$allSettings["gapi"],
      	$validationRules
      );

      if($validator->fails()){
	       return Redirect::to(URL::route('users.settings') . $showTab)->withInput($allSettings)->withErrors($validator)->with("error", "This form contains errors, please review and try again");
      }
      else{
      	$googleSettings = htmlspecialchars('<?php ' .
      	  'return array(
      	  "client_id" => "' . $allSettings["gapi"]["client_id"] . '",
      	  "service_account_name" => "' . $allSettings["gapi"]["service_account_name"] . '",
      	  "key_file_location" => base_path() . "' . $allSettings["gapi"]["key_file_location"] . '",
      	  "timezone" => "' . $allSettings["gapi"]["timezone"] . '",
      	  "calendar_id" => "' . $allSettings["gapi"]["calendar_id"] . '",
  	      );'
        );
	      File::put(base_path() . '/app/config/google.php',htmlspecialchars_decode($googleSettings));
      }
    }
    else{
      if(key_exists("admin_account",$allSettings)){
      	$showTab = "#account";
      	$validationRules = array(
      	  'email' => array('required','email'),
      	  'password'  =>'between:4,8',
      	  'password_confirmation'=>'between:4,8',
      	);

      	$validator = Validator::make(
      	  $allSettings["admin_account"],
      	  $validationRules
      	);

        // Add password validation only if user has edited it

       $validator->sometimes( 'password', 'required|confirmed', function($input){
            return ( !empty($input->password) || !empty($input->password_confirmation) );

       });

       $validator->sometimes( 'password_confirmation', 'required', function($input){
            return ( !empty($input->password) || !empty($input->password_confirmation) );

       });


      	if($validator->fails()){
      	  return Redirect::to(URL::route('users.settings') . $showTab)->withInput($allSettings)->withErrors($validator)->with("error", "This form contains errors, please review and try again");
      	}
      	else{
      	  $user = Auth::user();
      	  $user->email = $allSettings["admin_account"]["email"];

            // Check if user has entered the password then only update it otherwise update other values (not password)

            if ( !empty($allSettings["admin_account"]["password"]) && !empty($allSettings["admin_account"]["password_confirmation"]) ) {
      	  $user->password = Hash::make($allSettings["admin_account"]["password"]);
            }
            else {
              $temp_user = User::find(Auth::user()->id);
              $user->password = $temp_user->password;
          }
            $user->save();
      	}
      }
      else{
      	if(key_exists("leave_setting", $allSettings)){
      	  $showTab = "#leave";

      	  $allSettings["leave_setting"]["new_official_year_date"] = sprintf("%02s", $allSettings["leave_setting"]["official_year_day"]) . "-" . sprintf("%02s", $allSettings["leave_setting"]["official_year_month"]);

      	  $validationRules = array(
      	    'carry_forward_leaves' => 'required|numeric',
      	    'paternity_leaves'  =>'required|numeric',
      	    'maternity_leaves'=>'required|numeric',
      	    'paid_leaves'=>'required|numeric',
      	    'new_official_year_date' => "required|regex:^[\d]{2}-[\d]{2}^"
      	  );

      	  $validator = Validator::make(
      	    $allSettings["leave_setting"],
      	    $validationRules
      	  );

      	  if($validator->fails()){
      	    return Redirect::to(URL::route('users.settings') . $showTab)->withInput($allSettings)->withErrors($validator)->with("error", "This form contains errors, please review and try again");
      	  }
      	  else{

            $carry_forward_leaves = Leaveconfig::getConfig("carry_forward_leaves",date("Y"));
            $paternity_leaves = Leaveconfig::getConfig("paternity_leaves",date("Y"));
            $maternity_leaves = Leaveconfig::getConfig("maternity_leaves",date("Y"));
            $paid_leaves      = Leaveconfig::getConfig("paid_leaves",date("Y"));

            if(!isset($carry_forward_leaves->id)){
              $carry_forward_leaves = new leaveConfig();
              $carry_forward_leaves->leave_type = "carry_forward_leaves";
              $carry_forward_leaves->year = date("Y");
            }
            $carry_forward_leaves->leave_days = $allSettings["leave_setting"]["carry_forward_leaves"];

            if(!isset($paternity_leaves->id)){
              $paternity_leaves = new Leaveconfig();
              $paternity_leaves->leave_type = "paternity_leaves";
              $paternity_leaves->year = date("Y");
            }
            $paternity_leaves->leave_days = $allSettings["leave_setting"]["paternity_leaves"];

            if(!isset($maternity_leaves->id)){
              $maternity_leaves = new LeaveConfig();
              $maternity_leaves->leave_type = "maternity_leaves";
              $maternity_leaves->year = date("Y");
            }
            $maternity_leaves->leave_days = $allSettings["leave_setting"]["maternity_leaves"];

            if(!isset($paid_leaves->id)){
              $paid_leaves = new LeaveConfig();
              $paid_leaves->leave_type = "paid_leaves";
              $paid_leaves->year = date("Y");
            }
            $paid_leaves->leave_days = $allSettings["leave_setting"]["paid_leaves"];

            $carry_forward_leaves->save();
            $paternity_leaves->save();
            $maternity_leaves->save();
            $paid_leaves->save();

      	    $official_year_month = $allSettings["leave_setting"]["official_year_month"];
      	    $official_year_day = $allSettings["leave_setting"]["official_year_day"];

      	    $currYear = date("Y");
      	    $yearStart = YearStart::where("year", $currYear)->first();
      	    if($yearStart){
      	      $yearStart->startDay = $official_year_day;
      	      $yearStart->startMonth = $official_year_month;
      	      $yearStart->year = $currYear;
      	      $yearStart->save();
      	    }
      	    else{
      	      $yearStart = new YearStart();
      	      $yearStart->startDay = $official_year_day;
      	      $yearStart->startMonth = $official_year_month;
      	      $yearStart->year = $currYear;
      	      $yearStart->save();
      	    }
      	  }
      	}
      	else{
      	  if(key_exists("extra_leaves",$allSettings)){
      	    $showTab = "#extra_leave";

            $validationRules = array(
              'employee_name' => 'required',
              'leave_type'  =>'required',
              'from_date' => 'required|date'
            );

            $validator = Validator::make(
              $allSettings["extra_leaves"],
              $validationRules
            );

            $validator->sometimes( 'leaves_count', 'required|numeric', function($input){
              return (isset($input->leave_type) && ($input->leave_type == "extra"));
            });

            $validator->sometimes( 'description', 'required', function($input){
              return (isset($input->leave_type) && ($input->leave_type == "extra"));
            });


            if($validator->fails()){
              return Redirect::to(URL::route('users.settings') . $showTab)->withInput($allSettings)->withErrors($validator)->with("error", "This form contains errors, please review and try again");
            }

            $empName = $allSettings["extra_leaves"]["employee_name"];
            $extraLeaveType = $allSettings["extra_leaves"]["leave_type"];





            $carry_forward_leaves = Leaveconfig::getConfig("carry_forward_leaves",date("Y"));
            $paternity_leaves = Leaveconfig::getConfig("paternity_leaves",date("Y"));
            $maternity_leaves = Leaveconfig::getConfig("maternity_leaves",date("Y"));
            $paid_leaves      = Leaveconfig::getConfig("paid_leaves",date("Y"));


      	    switch($extraLeaveType){
      	      case "paternity":
            		$noOfLeaves = $paternity_leaves->leave_days;
            		$description = "Paternity";
            		break;
      	      case "maternity":
            		$noOfLeaves = $maternity_leaves->leave_days;
            		$description = "Maternity";
            		break;
      	      case "extra":
            		$noOfLeaves = $allSettings["extra_leaves"]["leaves_count"];
            		$description = $allSettings["extra_leaves"]["description"];
            		break;
            }

      	    $user = User::where("name",$empName)->first();
      	    $userId = $user->id;
      	    $forYear = date("Y");
      	    $fromDate = $allSettings["extra_leaves"]["from_date"];
      	    $fromDate_timestamp = strtotime($fromDate);
      	    $toDate_timestamp = $fromDate_timestamp + (((int)$noOfLeaves - 1) * 24 * 60 * 60);

      	    $toDate = date("Y-m-d",$toDate_timestamp);

      	    $extraLeave = new Extraleave();
      	    $extraLeave->user_id = $userId;
      	    $extraLeave->leaves_count = $noOfLeaves;
      	    $extraLeave->for_year = date("Y");
      	    $extraLeave->from_date = date("Y-m-d", strtotime($fromDate));
      	    $extraLeave->to_date = $toDate;
      	    $extraLeave->description = $description;
      	    $extraLeave->save();
      	  }
      	}
      }
    }
    return Redirect::to(URL::route('users.settings') . $showTab)->with('success', 'Settings updated successfully');
  }

  /*
  Function Name:  getExtraLeaves
  Author Name:    Nicolas Naresh
  Date:     June, 10 2014
  Parameters:   -
  Purpose:    this function provides the view for getting extra leaves for a given user name for a given year.
  */
  public function getExtraLeaves(){
    $inputs = Input::all();
    $username = $inputs["name"];
    $year = $inputs["year"];
    $user = User::where("name", "LIKE", "%" . $username . "%")->first();
    $paternityLeave = Extraleave::getPaternityLeaveInfo($user->id, $year);
    $maternityLeave = Extraleave::getMaternityLeaveInfo($user->id, $year);
    if(!$paternityLeave){
      $paternityLeave = null;
    }
    if(!$maternityLeave){
      $maternityLeave = null;
    }
    $extraLeaves = Extraleave::getExtraLeavesInfo($user->id, $year);
    return View::make("users.extra_leaves")->with("data", array("paternityLeave" => $paternityLeave, "maternityLeave" => $maternityLeave, "extraLeaves" => $extraLeaves, "username" => $username));
  }
}
