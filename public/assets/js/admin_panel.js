/**
  Page Name:                admin_panel.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin_panel
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/

// Initialize the datatables
$('#leavesTable').DataTable();



// opens datepicker calendar on click of calendar icon appended to the date control input element
$(document).on("click",".glyphicon-calendar", function(){
  $(this).prev(".ui-datepicker-trigger").click();
});


// on keyup of input element with id user-search, makes an ajax call to search for input value
$(document).on("keyup", "#user-search",function(){
  var $this = $(this);
  var value = $this.val();
  if(window.xhr){
    window.xhr.abort();
  }
  
  window.xhr = $.ajax({
    url: $this.data("search_url"),
    data: {name: value},
    type: "post",
    success: function(retdata){
      $("#user-listing-tbody").html(retdata);
    }
  });
});

