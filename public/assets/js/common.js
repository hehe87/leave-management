/**
  Page Name:                        common.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin or user panels
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/

$('#leave_type').on('change', function(elem){
  $leave_type = $(this).val();
  $csr_container = $('#csr-container');
  
  if( 'CSR' == $leave_type )
  {
    $csr_container.show();
  }
  
  else if( "LEAVE" == $leave_type )
  {
    $csr_container.hide();
  }

});

$('#addSlot').on('click', function(e){
  $('#timeContainer').append($('#timeSlot').html());
});

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

