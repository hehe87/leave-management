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
    Purpose:	      	This function calculates total number of leaves for current year for current user object using his/her date of joining.
  */
  public function getTotalLeaves(){
    $currentYear = (int)date("Y");
    $previousYear = $currentYear - 1;
    $thisYearTotalLeaves = $this->getTotalLeavesForYear($currentYear);
    if(date("Y",strtotime($this->doj)) != date("Y")){
      $previousYearLeaves = $this->getTotalLeavesForYear($previousYear);
      if($previousYearLeaves >= Leaveconfig::getConfig('carry_forward_leaves',$previousYear)->leave_days){
        $thisYearTotalLeaves += Leaveconfig::getConfig('carry_forward_leaves',$previousYear)->leave_days;
      }
      else{
        $thisYearTotalLeaves += $previousYearLeaves;
      }
    }
    
    return $thisYearTotalLeaves;
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
    return $this->getRemainingLeavesForYear(date("Y"));
  }


  /**
    Function Name     : getTotalLeavesForYear
    Author Name       : Nicolas Naresh
    Date              : June 16, 2014
    Parameters        : $year
    Purpost           : this function returns the count of all the leaves for current user for a given year.
  */
  public function getTotalLeavesForYear($year){
    $currentDate = new DateTime(date("Y-m-d", mktime(0,0,0,1,1,$year)));
    $currentYear = (int)$currentDate->format("Y");
    $paidLeaves = Leaveconfig::getConfig("paid_leaves", $currentYear)->leave_days;
    $allLeaves = $paidLeaves;
    $optionalHolidays = Holiday::where("holidayType", "=", "OPTIONAL")->where(DB::raw('EXTRACT( YEAR from "holidayDate"::date)'), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    $optionalHolidaysCount = count(array_keys($optionalHolidays->toArray()));

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

    $lastLeaveDateInYearOfJoining = new DateTime(date("Y-m-d", mktime(0,0,0,$joiningYearStartMonth,$joiningYearStartDay,$joiningYear)));

    $yearsInCompany = (int)$currentDate->format("Y") - (int)$dateOfJoining->format("Y");

    $isJoinedInCurrentYear = $yearsInCompany == 0 ? true : false;

    $isJoinedBeforeLastLeaveDateOfJoiningYear = (((int)$dateOfJoining->format("m") == 1) && ((int)$dateOfJoining->format("d") <= 15)) ? true : false;

    if(!$isJoinedBeforeLastLeaveDateOfJoiningYear && !$isJoinedInCurrentYear){
      $yearsInCompany -= 1;
    }

    $allLeaves += $optionalHolidaysCount;


    $leavesPerMonth = $allLeaves / 12;

    if($isJoinedInCurrentYear){
      $lastYearDateTS = mktime(0,0,0,12,31,$currentYear);
      $joiningDateTS = mktime(0,0,0,$dateOfJoining->format("m"), $dateOfJoining->format("d"), $dateOfJoining->format("Y"));
      $diff = $lastYearDateTS - $joiningDateTS;
      $diffMonths = $diff / (24 * 60 * 60 * 30);
      $allLeaves = round($diffMonths * $leavesPerMonth);
    }
    else{
      $allLeaves += $yearsInCompany;
    }

    $extraLeaves = Extraleave::where("user_id", $this->id)->where("for_year", $currentYear)->get();

    foreach($extraLeaves as $extraL){
      $allLeaves += $extraL->leaves_count;
    }

    return $allLeaves;
  }

  /**
    Function Name     : getRemainingLeavesForYear
    Author Name       : Nicolas Naresh
    Date              : June 16, 2014
    Parameters        : $year
    Purpost           : this function returns the count of all the leaves for current user for a given year.
  */
  public function getRemainingLeavesForYear($year){
    $totalLeaves = $this->getTotalLeavesForYear($year);
    $remainingLeaves = $totalLeaves;
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
    $extraLeaves = Extraleave::where("user_id", $this->id)->where("for_year", $year)->get();

    foreach($extraLeaves as $extraL){
      $remainingLeaves -= $extraL->leaves_count;
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
