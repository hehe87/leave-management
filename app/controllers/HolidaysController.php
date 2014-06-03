<?php
/**
  Class Name:                       HolidaysController
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This class acts as a controller for holiday management
  Table referred:		    holidays
  Table updated:	            holidays
  Most Important Related Files:     models/Holiday.php
*/

class HolidaysController extends \BaseController {
  
  public function index(){
    
    if(!Auth::check()){
      return Redirect::to(URL::route("userLogin"));
    }
    
    
    $currentYear = date("Y");
    $holidays = Holiday::where(DB::raw("YEAR(holidayDate)"), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    return View::make("holidays.index")->with("holidays",$holidays);
  }
  
  public function create(){
    if(!Auth::check()){
      return Redirect::to(URL::route("userLogin"));
    }
    $holiday = new Holiday();
    return View::make("holidays.form")->with("holiday", $holiday);
  }
  
  public function store(){
    if(!Auth::check()){
      return Redirect::to(URL::route("userLogin"));
    }
    $formData = Input::except("_token");
    $validator = Holiday::validateHolidayForm($formData);
    if($validator->fails())
    {
      return Redirect::to(URL::route("holidayCreate"))->withErrors($validator)->withInput();
    }
    else{
      Holiday::create($formData);
      return Redirect::to(URL::route("holidaysListing"));
    }
  }
  
  public function edit(){
    if(!Auth::check()){
      return Redirect::to(URL::route("userLogin"));
    }
  }
  
  public function update(){
    if(!Auth::check()){
      return Redirect::to(URL::route("userLogin"));
    }
  }
  
}