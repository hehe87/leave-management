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

$(document).on("ready",function(){
  if($("#addSlot").length == 1){
    window.timeSlotHtml = $('#timeSlot').html();
    $('#addSlot').on('click', function(e){
      $('#timeSlot').append(window.timeSlotHtml);
    });
  }
});



$(document).on("ready",function(){
  
  //applies datepicker on date_control class
  $(".date_control").datepicker({
    showOn : "button",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true
  });
  
  //removes time part from date_control input value
  $(".date_control").each(function(){
    if($(this).val() != ""){
      $(this).val($(this).val().split(" ")[0]);
    }
  });
  
});

