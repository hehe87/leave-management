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
  
  
  
  public function __construct()
  {
    $this->beforeFilter('auth');
  }
  
  
  /**
    Function Name: 		index
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying all the users in a table
  */
  public function index(){
    $currentYear = date("Y");
    if(Config::get("database.default") == "mysql"){
       $holidays = Holiday::where(DB::raw('YEAR(holidayDate)'), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    }
    else{
      $holidays = Holiday::where(DB::raw('EXTRACT(YEAR FROM "holidayDate"::date)'), "=", $currentYear)->orderBy("holidayDate", "asc")->get();
    }
    return View::make("holidays.index")->with("holidays",$holidays);
  }
  
  
  /**
    Function Name: 		create
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for displaying holiday addition form
  */
  public function create(){
    $holiday = new Holiday();
    return View::make("holidays.create")->with("holiday", $holiday);
  }
  
  
  /**
    Function Name: 		store
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	-
    Purpose:			This function acts as an action for storing the filled information about
				holiday to the database table holidays
  */
  public function store(){
    $formData = Input::except("_token");
    $validator = Holiday::validateHolidayForm($formData);
    if($validator->fails())
    {
      return Redirect::to(URL::route("holidayCreate"))->withErrors($validator)->withInput();
    }
    else{
      $formData["holidayType"] = "OPTIONAL";
      Holiday::create($formData);
      return Redirect::to(URL::route("holidaysListing"));
    }
  }
  
  
  /**
    Function Name: 		edit
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function acts as an action for displaying edit holiday form, where the
				retlated to the given holiday can be edited
  */
  public function edit($id){
    $holiday = Holiday::find($id);
    return View::make("holidays.edit")->with("holiday", $holiday);
  }
  
  /**
    Function Name: 		edit
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function updates the given holidays information to database with
				the information updated in the edit form
  */
  public function update($id){
    $holiday = Holiday::find($id);
    $formData = Input::except("_token");
    $validator = Holiday::validateHolidayForm($formData);
    if($validator->fails())
    {
      return Redirect::to(URL::route("holidayEdit",array("id" => $id)))->withErrors($validator)->withInput();
    }
    else{
      $holiday->update($formData);
      return Redirect::to(URL::route("holidaysListing"));
    }
    $holiday->update(Input::except("_token"));
    return Redirect::to(URL::route("holidaysListing"));
  }
  
  
  /**
    Function Name: 		destroy
    Author Name:		Nicolas Naresh
    Date:			June, 03 2014
    Parameters:	            	$id
    Purpose:			This function removes the specified holiday from database
  */
  public function destroy($id)
  {
    Holiday::destroy($id);
    return Redirect::to(URL::route('holidaysListing'));
  }
  
}