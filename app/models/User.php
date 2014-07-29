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
    'lunch_start_time',
    'lunch_end_time',
    'doj',
    'dob',
    'phone',
    'altPhone',
    'remark'
  );


  /*
    Function Name:  scopeEmployee
    Author Name:  Nicolas Naresh
    Date:   May, 30 2014
    Parameters:
    Purpose:        This function acts as a filter while getting all users
    which are not admins
  */

  public function scopeEmployee($query){
    return $query->where("employeeType", "<>", "ADMIN");
  }



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




  /*
    Function Name: 	validateRegistrationForm
    Author Name:	Nicolas Naresh
    Date:		May, 30 2014
    Parameters:	        registrationDataArr
    Purpose:	      	This function will take an array of registration form values and validates
			them
  */
  public static function validateRegistrationForm($registrationDataArr, $id = null){

    if(key_exists("doj", $registrationDataArr) && !empty($registrationDataArr["doj"])){
      $registrationDataArr["doj"] = date("Y-m-d",strtotime($registrationDataArr["doj"]));
    }
    if(key_exists("dob", $registrationDataArr) && !empty($registrationDataArr["dob"])){
      $registrationDataArr["dob"] = date("Y-m-d",strtotime($registrationDataArr["dob"]));
    }

    if($id != null){
      $validationRules = array(
          'name' => array('required', 'min:5'),
          'email' => array('required','email', 'unique:users,email,'.$id),
          'doj' => array('required','date'),
          'dob' => array('required','date'),
          'inTime' => array('required', 'date_format:H:i:s'),
          'outTime' => array('required', 'date_format:H:i:s'),
          'phone' => array('required','regex:/[0-9]{10}/'),
          'altPhone' => array('regex:/[0-9]{10}/')
      );
      
    }
    else{
      $validationRules = array(
        'name' => array('required', 'min:5'),
        'email' => array('required','email', 'unique:users'),
        'doj' => array('required','date'),
        'dob' => array('required','date'),
        'inTime' => array('required', 'date_format:H:i:s'),
        'outTime' => array('required', 'date_format:H:i:s'),
        'phone' => array('required','regex:/[0-9]{10}/'),
        'altPhone' => array('regex:/[0-9]{10}/')
      );
    }



    $validator = Validator::make(
          $registrationDataArr,
          $validationRules
      );
    return $validator;
  }



  /*
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
    return $thisYearTotalLeaves;
  }


  /*
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


  /*
    Function Name     : getTotalLeavesForYear
    Author Name       : Nicolas Naresh
    Date              : June 16, 2014
    Parameters        : $year
    Purpost           : this function returns the count of all the leaves for current user for a given year.
  */
  public function getTotalLeavesForYear($year){
    $januaryOne = new DateTime(date("Y-m-d", mktime(0,0,0,1,1,$year)));
    $paidLeaves = Leaveconfig::getConfig("paid_leaves", $year)->leave_days;
    $allLeaves = $paidLeaves;
    if(Config::get("database.default") == "mysql"){
      $optionalHolidays = Holiday::where("holidayType", "=", "OPTIONAL")->where(DB::raw('YEAR(holidayDate)'), "=", $year)->orderBy("holidayDate", "asc")->get();
    }
    else{
      $optionalHolidays = Holiday::where("holidayType", "=", "OPTIONAL")->where(DB::raw('EXTRACT( YEAR from "holidayDate"::date)'), "=", $year)->orderBy("holidayDate", "asc")->get();
    }
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

    $yearsInCompany = (int)$januaryOne->format("Y") - (int)$dateOfJoining->format("Y");

    $isJoinedInCurrentYear = $yearsInCompany == 0 ? true : false;

    $isJoinedBeforeLastLeaveDateOfJoiningYear = (((int)$dateOfJoining->format("m") == 1) && ((int)$dateOfJoining->format("d") <= 15)) ? true : false;

    if(!$isJoinedBeforeLastLeaveDateOfJoiningYear && !$isJoinedInCurrentYear){
      $yearsInCompany -= 1;
    }

    $allLeaves += $optionalHolidaysCount;


    $leavesPerMonth = $allLeaves / 12;

    if($isJoinedInCurrentYear){
      $lastYearDateTS = mktime(0,0,0,12,31,$year);
      $joiningDateTS = mktime(0,0,0,$dateOfJoining->format("m"), $dateOfJoining->format("d"), $dateOfJoining->format("Y"));
      $diff = $lastYearDateTS - $joiningDateTS;
      $diffMonths = $diff / (24 * 60 * 60 * 30);
      $allLeaves = round($diffMonths * $leavesPerMonth);
    }
    else{
      $allLeaves += $yearsInCompany;
    }

    $extraLeaves = Extraleave::where("user_id", $this->id)->where("for_year", $year)->get();

    foreach($extraLeaves as $extraL){
      $allLeaves += $extraL->leaves_count;
    }

    $currentDate = new DateTime();


    $currentYearStart = YearStart::where("year", date("Y"))->first();
    $currentYearJan = new DateTime(date("Y-m-d",mktime(0,0,0,1,1,date("Y"))));

    if($currentYearStart){
      $currentYearStartDay = $currentYearStart->startDay;
      $currentYearStartMonth = $currentYearStart->startMonth;
    }
    else{
      $currentYearStartDay = 15;
      $currentYearStartMonth = 1;
    }

    $lastLeaveDateInCurrentYear = new DateTime(date("Y-m-d",mktime(0,0,0,$currentYearStartMonth,$currentYearStartDay, date("Y"))));

    if((int)$year == (int)date("Y")){
      if($currentDate >= $currentYearJan && $currentDate <= $lastLeaveDateInCurrentYear){
        $allLeaves += $this->getTotalLeavesForYear(((int)$year-1));
      }
      else{
        $allLeaves += $this->carry_forward_leaves;
      }
    }
    return $allLeaves;
  }

  /*
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

  /*
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


  /*
  Function Name :       approvedLeaves
  Author Name   :       Nicolas Naresh
  Date          :       25 June, 2014
  Parameters    :       $year
  Purpose       :       to get the all approved leaves for current user for a given year
  */
  public function approvedLeaves($year){
    if(Config::get("database.default") == "mysql"){
      $leaves = $this->hasMany('Leave')->where(DB::raw('YEAR(leave_date)'), $year)->get();
    }
    else{
      $leaves = $this->hasMany('Leave')->where(DB::raw('EXTRACT(year FROM "leave_date"::date)'), $year)->get();
    }

    $approved = array();
    foreach($leaves as $leave){
      if($leave->leaveStatus() == "APPROVED"){
        $approved[] = $leave;
      }
    }
    return $approved;
  }

  /*
  Function Name :       pendingLeaves
  Author Name   :       Nicolas Naresh
  Date          :       25 June, 2014
  Parameters    :       $year
  Purpose       :       to get the all pending leaves for current user for a given year
  */
  public function pendingLeaves($year){
    if(Config::get("database.default") == "mysql"){
      $leaves = $this->hasMany('Leave')->where(DB::raw('YEAR(leave_date)'), $year)->get();
    }
    else{
      $leaves = $this->hasMany('Leave')->where(DB::raw('EXTRACT(year FROM "leave_date"::date)'), $year)->get();
    }
    $pending = array();
    foreach($leaves as $leave){
      if($leave->leaveStatus() == "PENDING"){
        $pending[] = $leave;
      }
    }
    return $pending;
  }

  /*
  Function Name :       rejectedLeaves
  Author Name   :       Nicolas Naresh
  Date          :       25 June, 2014
  Parameters    :       $year
  Purpose       :       to get the all rejected leaves for current user for a given year
  */
  public function rejectedLeaves($year){
    if(Config::get("database.default") == "mysql"){
      $leaves = $this->hasMany('Leave')->where(DB::raw('YEAR(leave_date)'), $year)->get();
    }
    else{
      $leaves = $this->hasMany('Leave')->where(DB::raw('EXTRACT(year FROM "leave_date"::date)'), $year)->get();
    }
    $rejected = array();
    foreach($leaves as $leave){
      if($leave->leaveStatus() == "REJECTED"){
        $rejected[] = $leave;
      }
    }
    return $rejected;
  }

  /*
  Function Name :       appliedLeaves
  Author Name   :       Nicolas Naresh
  Date          :       25 June, 2014
  Parameters    :       $year
  Purpose       :       to get the all applied leaves for current user for a given year
  */
  public function appliedLeaves($year){
    return $this->hasMany('Leave')->where(DB::raw('EXTRACT(year FROM "leave_date"::date)'), $year)->get();
  }

  /*
  Function Name :       extraLeaves
  Author Name   :       Nicolas Naresh
  Date          :       25 June, 2014
  Parameters    :       $year
  Purpose       :       to get the all extra leaves for current user for a given year
  */
  public function extraLeaves($year){
    $extraLeaves = Extraleave::where("user_id", $this->id)->where("for_year", $year)->get();
    return $extraLeaves;
  }



  /*
  Function Name   :     generatePassword
  Author Name      :     Jack Braj
  Date:                 :     June 18, 2014
  Parameters        :     numAlpha, numNonAlpha
  Purpose             :     Generate random password for the new user
   */

  public static function generatePassword($numAlpha=6,$numNonAlpha=2)
  {
    $listAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $listNonAlpha = ',;:!?.$/*-+&@_+;./*&?$-!,';

    return str_shuffle(
      substr(str_shuffle($listAlpha),0,$numAlpha) .
      substr(str_shuffle($listNonAlpha),0,$numNonAlpha)
    );
  }


}
