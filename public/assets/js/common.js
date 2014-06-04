/**
  Page Name:                        common.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin or user panels
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/

$(document).on("ready",function(){
  
  //applies datepicker on date_control class
  $(".date_control").datepicker({
    showOn : "button",
    dateFormat: "yy-mm-dd"
  });
  
  //removes time part from date_control input value
  $(".date_control").each(function(){
    $(this).val($(this).val().split(" ")[0]);
  });
  
});