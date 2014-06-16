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
$('#leavesTable').DataTable( {
        "order": [[ 4, "asc" ]]
    } );

// Initialize timepickers
 $('.timepicker').timepicker({
    minuteStep: 5,
    showInputs: false,
    disableFocus: true
  });

// opens datepicker calendar on click of calendar icon appended to the date control input element
$(document).on("click",".glyphicon-calendar", function(){
  $(this).prev(".ui-datepicker-trigger").click();
});


// on keyup of input element with id user-search, makes an ajax call to search for input value
$(document).on("keyup", "#user-search",function(e){
  if(e.keyCode == 13){
    e.preventDefault();
    return;
  }
  if((e.keyCode != 40) && (e.keyCode != 38)){
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
        $("#user-listing-tbody").closest("table").removeClass("hide");
      }
    });
  }
});

$(document).on("keydown", "#user-search",function(e){
  
  var $this = $(this);
  if(e.keyCode == 13){
    if(!$("#user-listing-tbody").closest("table").hasClass("hide")){
      e.preventDefault();
      $("#user-search").val($.trim($("#user-listing-tbody tr.active td").text()));
      $("#user-listing-tbody").closest("table").addClass("hide");
      
      if(typeof $("#user-search").data("onselect") != "undefined"){
        window[$("#user-search").data("onselect")]($("#user-search").data("onselectajaxurl"),$("#user-search").val(), window.currentYear);
      }
    }
  }
  if(e.keyCode == 40 || e.keyCode == 38){
    e.preventDefault();
    if(e.keyCode == 40){
      var currIndex = $("#user-listing-tbody tr.active").index();
      if(currIndex == -1){
        $("#user-listing-tbody tr").first().addClass("active");
      }
      else{
        if(currIndex == ($("#user-listing-tbody tr").length - 1)){
          $("#user-listing-tbody tr.active").removeClass("active");
          $("#user-listing-tbody tr").first().addClass("active");
        }
        else{
          $("#user-listing-tbody tr.active").next().addClass("active");
          $("#user-listing-tbody tr.active").first().removeClass("active");
        }
        
      }
      
      
    }
    else{
      var currIndex = $("#user-listing-tbody tr.active").index();
      if(currIndex == 0){
        $("#user-listing-tbody tr").removeClass("active");
        $("#user-listing-tbody tr").last().addClass("active");
      }
      else{
        $("#user-listing-tbody tr.active").prev().addClass("active");
        $("#user-listing-tbody tr.active").last().removeClass("active");
      }
    }
  }
  
});


$(document).on("submit","#report-form",function(e){
  var hasErrors = false;
  if($("#leave-type").val() != "ALL"){
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
  }
  
  if(hasErrors){
    alert("Please enter/select all search inputs first!!");
    return false;
  }
  else{
    $("#report-form").submit();
  }
});

$(document).on("change","#report-form #leave-type",function(){
  var $form = $("#report-form");
  var inputs = $form.find("input");
  var selects = $form.find("select");
  if($(this).val() == "ALL"){
    inputs.hide();
    selects.hide();
  }
  else{
    inputs.show();
    selects.show(); 
  }
  $("#report-form #leave-type").show();
  $("input[name='generate_report']").show();
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
  $(this).closest("table").addClass("hide");
  var name = $(this).html();
  var $input = $(this).closest("#lm-autosearch").prev();
  $input.val($.trim(name));
  if(typeof $input.data("onselect") != "undefined"){
    window[$input.data("onselect")]($input.data("onselectajaxurl"),$input.val(), window.currentYear);
  }
});

function getExtraLeaves(ajaxurl, username, year){
  $.ajax({
    url: ajaxurl,
    data: {name : username, year: year},
    type: "post",
    success: function(retdata){
      $("#extra_leave .row .col-sm-12").html(retdata);
      $(".date_control").datepicker({
        showOn : "both",
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      });
    }
  });
}

$(document).on("change","input[name='extra_leaves[leave_type]']", function(){
  if($(this).hasClass("extra-leave-leave_type")){
    $(".extra-leave-description").addClass("in");
  }
  else{
    $(".extra-leave-description").removeClass("in");
  }
  $("#extra-leave-fromdate").addClass("in");
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


$(document).on("click", ".settings-tab-links li a", function (e) {
  e.preventDefault()
  $(this).tab('show');
})

$(document).on("ready",function(e){
  var tabID = location.href.split("#")[1];
  if(typeof tabID != "undefined"){
    $("a[href='#"+tabID+"']").tab('show');
  }

  if($("#report-form #leave-type").length == 1){
    var $form = $("#report-form");
    var inputs = $form.find("input");
    var selects = $form.find("select");
    if($("#report-form #leave-type").val() == "ALL"){
      inputs.hide();
      selects.hide();
    }
    $("#report-form #leave-type").show();
    $("input[name='generate_report']").show();
  }
});

