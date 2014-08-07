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

    public static function validateHolidayForm($formData, $id=null){

      if($id != null){

        $rules = array(
          'holidayDate' => array('required','date', 'unique:holidays,holidayDate,' . $id),
          'holidayDescription' => array('required', 'max:255')
        );
      }
      else{
        $rules = array(
          'holidayDate' => array('required','date','unique:holidays'),
          'holidayDescription' => array('required', 'max:255')
        );
      }
      $validator = Validator::make(
        $formData,
        $rules
      );


      return $validator;
    }
  }
?>