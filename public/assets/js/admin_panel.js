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
  var view = $(this).data("view");
  if(typeof view == "undefined"){
    view = null;
  }
  var value = $this.val();
  var onBlank = $(this).data("onblank");
  if(typeof onBlank == "undefined"){
    onBlank = "";
  }
  if(window.xhr){
    window.xhr.abort();
  }
  
  window.xhr = $.ajax({
    url: $this.data("search_url"),
    data: {name: value, view: view, onblank: onBlank},
    type: "post",
    success: function(retdata){
      $("#user-listing-tbody").html(retdata);
      $("#user-listing-tbody").closest("table").show();
    }
  });
});


$(document).on("submit","#report-form",function(e){
  var hasErrors = false;
  var $form = $(this);
  var inputs = $(this).find("input");
  var selects = $(this).find("select");
  for(i=0;i<inputs.length;i++){
    if($.trim($(inputs[i]).val()) == ""){
      hasErrors = true;
      break;
    }
  }
  if(!hasErrors){
    for(i=0;i<selects.length;i++){
      if($.trim($(selects[i]).val()) == ""){
        hasErrors = true;
        break;
      }
    }
  }
  if(hasErrors){
    alert("Please enter/select all search inputs first!!");
    return false;
  }
  else{
    $("#report-form").submit();
  }
});



$(document).on("change", "#date-option", function(){
  var this_val = $(this).val();
  switch(this_val){
    case "between-dates":
      $("#date_option_inputs").html(getBetweenDatesInputHTML());
      break;
    case "by-month":
      $("#date_option_inputs").html(getMonthInputHTML());
      break;
    case "by-year":
      $("#date_option_inputs").html(getYearInputHTML());
      break;
    case "by-date":
      $("#date_option_inputs").html(getByDateInputHTML());
      break;
  }
  $(".date_control").datepicker({
    showOn : "both",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true
  });
});


$(document).on("click","#lm-autosearch table tr td", function(){
  $(this).closest("table").hide();
  var name = $(this).html();
  $(this).parent().parent().parent().parent().prev().val($.trim(name));
});



function getMonthInputHTML(){
  var htm = '<div class="col-sm-12"><select class="form-control" id="date-option" name="month">';
  for(i=1;i<=12; i++){
    htm += '<option value="' + i + '">' + i + '</option>';
  }
  htm += '</select></div>';
  return htm;
}

function getYearInputHTML(){
  var htm = '<div class="col-sm-12"><select class="form-control" id="date-option" name="year">';
  for(i=2014;i<=2015; i++){
    htm += '<option value="' + i + '">' + i + '</option>';
  }
  htm += '</select></div>';
  return htm;
}

function getBetweenDatesInputHTML(){
  var htm = '<div class="col-sm-6"><input type="text" name="from_date" class="form-control date_control" placeholder="From"/></div>';
  htm += '<div class="col-sm-6"><input type="text" name="to_date" class="form-control date_control" placeholder="To"/></div>';
  return htm;
}

function getByDateInputHTML(){
  var htm = '<div class="col-sm-12"><input type="text" name="on_date" class="form-control date_control" placeholder="On Date"/></div>';
  return htm;
}

