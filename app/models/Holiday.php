<?php
  /**
    Class Name:                       Holiday
    author :		              Nicolas Naresh
    Date:			      June, 03 2014
    Purpose:		              This class acts as a model for holidays table
    Table referred:		      holidays
    Table updated:	              holidays
    Most Important Related Files:     -
  */
  class Holiday extends Eloquent{
    public $fillable = array(
      'holidayDate',
      'holidayType',
      'holidayDescription'
    );
    
    public static function validateHolidayForm($formData){
      $validator = Validator::make(
      $formData,
      array(
          'holidayDate' => array('required','date'),
          'holidayDescription' => array('required')
        )
      );
      
      return $validator;
    }
  }
?>