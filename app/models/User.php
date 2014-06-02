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
  public static function validateRegistrationForm($registrationDataArr){
    $validator = Validator::make(
      $registrationDataArr,
      array(
	'name' => array('required', 'min:5'),
	'password'  =>'required|between:4,8|confirmed',
	'password_confirmation'=>'required|between:4,8',
	'email' => array('required','email'),
	'doj' => array('required','date'),
	'dob' => array('required','date'),
	'phone' => array('required','regex:/[0-9]{10}/'),
	'altPhone' => array('required','regex:/[0-9]{10}/')
      )
    );
    return $validator;
  }
}
