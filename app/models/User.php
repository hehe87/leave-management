<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('password');
  
  public $fillable = array(
    'name',
    'email',
    'password',
    'employeeType',
    'inTime',
    'outTime',
    'doj',
    'dob',
    'phone',
    'altPhone'
  );
  
  /**
   * Get the unique identifier for the user.
   *
   * @return mixed
   */
  public function getAuthIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Get the password for the user.
   *
   * @return string
   */
  public function getAuthPassword()
  {
    return $this->password;
  }

  /**
   * Get the token value for the "remember me" session.
   *
   * @return string
   */
  public function getRememberToken()
  {
    return $this->remember_token;
  }

  /**
   * Set the token value for the "remember me" session.
   *
   * @param  string  $value
   * @return void
   */
  public function setRememberToken($value)
  {
    $this->remember_token = $value;
  }

  /**
   * Get the column name for the "remember me" token.
   *
   * @return string
   */
  public function getRememberTokenName()
  {
    return 'remember_token';
  }

  /**
   * Get the e-mail address where password reminders are sent.
   *
   * @return string
   */
  public function getReminderEmail()
  {
    return $this->email;
  }
  
  
  
  
  /**
    Function Name: 	validateRegistrationForm
    Author Name:	Nicolas Naresh
    Date:		May, 30 2014
    Parameters:	        registrationDataArr
    Purpose:	      	This function will take an array of registration form values and validates
			them
  */
  public static function validateRegistrationForm($registrationDataArr, $requiredPasswordValidation = true){
    
    if($requiredPasswordValidation){
      $passwordValidation = array(
	'password'  =>'required|between:4,8|confirmed',
	'password_confirmation'=>'required|between:4,8',
      );
    }
    else{
      if(!empty($registrationDataArr["password"]) || !empty($registrationDataArr["password_confirmation"])){
	$passwordValidation = array(
	  'password'  =>'required|between:4,8|confirmed',
	  'password_confirmation'=>'required|between:4,8',
	);
      }
      else{
	$passwordValidation = array();
      }
    }
    
    $validator = Validator::make(
      $registrationDataArr,
      array_merge(array(
	'name' => array('required', 'min:5'),
	'email' => array('required','email'),
	'doj' => array('required','date'),
	'dob' => array('required','date'),
	'inTime' => array('required', 'date_format:H:i:s'),
	'outTime' => array('required', 'date_format:H:i:s'),
	'phone' => array('required','regex:/[0-9]{10}/'),
	'altPhone' => array('required','regex:/[0-9]{10}/')
      ),$passwordValidation)
    );
    return $validator;
  }
  
  
  
  /**
    Function Name: 	getTotalLeaves
    Author Name:	Nicolas Naresh
    Date:		June, 02 2014
    Parameters:	        -
    Purpose:	      	This function calculates total number of leaves for current year for current user object
			using his/her date of joining.
  */
  public function getTotalLeaves(){
    $paidLeaves = Config::get("leave_config.paid_leaves");
    $allLeaves = $paidLeaves;
    $currentDate = new DateTime(date("Y-m-d"));
    $currentYear = (int)$currentDate->format("Y");
    $optionalHolidays = Holiday::where("holidayType", "=", "OPTIONAL")->where(DB::raw("YEAR(holidayDate)"), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    
    $optionalHolidaysCount = count(array_keys($optionalHolidays->toArray()));
    
    
    
    $nonOptionalHolidays = Holiday::where("holidayType", "=", "NONOPTIONAL")->where(DB::raw("YEAR(holidayDate)"), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    $dateOfJoining = new DateTime($this->doj);
    $joiningYear = (int)$dateOfJoining->format("Y");
    $joiningYearStart = YearStart::where("year", $joiningYear)->first();
    if($joiningYearStart){
      $joiningYearStartDay = $joiningYearStart->startDay;
      $joiningYearStartMonth = $joiningYearStart->startMonth;
    }
    else{
      $joiningYearStartDay = 15;
      $joiningYearStartMonth = 1;
    }
    //$config_last_leave_date = Config::get("leave_config.new_official_year_date");
    //$config_last_leave_date = explode("-",$config_last_leave_date);
    //$allMonths = array("Jan" => 1, "Feb" => 2, "Mar" => 3, "Apr" => 4,
    //  "May" => 5, "Jun" => 6, "Jul" => 7, "Aug" => 8, "Sep" => 9, "Oct" => 10, "Nov" => 11, "Dec" => 12);
    //$mon = $allMonths[$config_last_leave_date[1]]
    //$d = $config_last_leave_date[0];
    $lastLeaveDateInYearOfJoining = new DateTime(date("Y-m-d", mktime(0,0,0,$joiningYearStartMonth,$joiningYearStartDay,$joiningYear)));
    
    $yearsInCompany = (int)$currentDate->format("Y") - (int)$dateOfJoining->format("Y");
    $isJoinedInCurrentYear = $yearsInCompany == 0 ? true : false;
    
    $isJoinedBeforeLastLeaveDateOfJoiningYear = (((int)$dateOfJoining->format("m") == 1) && ((int)$dateOfJoining->format("d") <= 15)) ? true : false;
    
    if(!$isJoinedBeforeLastLeaveDateOfJoiningYear && !$isJoinedInCurrentYear){
      $yearsInCompany -= 1;
    }
    foreach($optionalHolidays as $oHoliday){
      $allLeaves += 1;
    }
//    if($isJoinedInCurrentYear){
//      $joiningDateUT = strtotime($this->doj);
//      foreach($optionalHolidays as $oHoliday){
//	$oHolidayDate = new DateTime($oHoliday->holidayDate);
//	$oHolidayDateUT = strtotime($oHoliday->holidayDate);
//	if($joiningDateUT < $oHolidayDateUT){
//	  $allLeaves += 1;
//	}
//      }
//    }
//    else{
//      foreach($optionalHolidays as $oHoliday){
//	$allLeaves += 1;
//      }
//    }
    
    $allLeaves += $yearsInCompany;
    return $allLeaves;
  }
  
  
  /**
    Function Name: 	getRemainingLeaves
    Author Name:	Nicolas Naresh
    Date:		June, 02 2014
    Parameters:	        -
    Purpose:	      	This function calculates total number of leaves for current year for current user object
			using his/her date of joining.
  */
  public function getRemainingLeaves(){
    $currentDate = new DateTime(date("Y-m-d"));
    $currentYear = (int)$currentDate->format("Y");
    
    $totalLeaves = $this->totalLeaves;
    $remainingLeaves = $totalLeaves;
    $joiningDate = $this->doj;
    $optionalHolidays = Holiday::where("holidayType", "=", "OPTIONAL")->where(DB::raw("YEAR(holidayDate)"), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    foreach($optionalHolidays as $oHoliday){
      $oh = strtotime($oHoliday->holidayDate);
      $jd = strtotime($this->doj);
      if($oh < $jd){
	$remainingLeaves -= 1;
      }
    }
    $userLeaves = $this->leaves()->get();
    foreach($userLeaves as $uLeave){
      $isApproved = true;
      foreach($uLeave->approvals as $approval){
	if($approval->approved != "YES"){
	  $isApproved = false;
	  break;
	}
      }
      if($isApproved){
	$remainingLeaves -= 1;
      }
    }
    return $remainingLeaves;
  }
  
  /**
  Function Name	: 			leaves
  Author Name		:		Jack Braj
  Date			:		June 03, 2014
  Parameters		:	    	none
  Purpose		:		Return leave relationship for eloquent
  */
	
  public function leaves()
  {
	  return $this->hasMany('Leave');
  }
  
}
