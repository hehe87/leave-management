/**
  Page Name:                        common.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin or user panels
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/
(function ( $ ) {
  $.blockUI =  function(){
    $("#blockUI").removeClass("hide");
  };
  $.unblockUI = function(){
    $("#blockUI").addClass("hide");
  };
}( jQuery ));

$(".in_time").val("09:30 AM");
$(".out_time").val("07:00 PM");


$('#leave_option').on('change', function(elem){
  var leave_option = $(this).val();
  $csr_container = $('#csr-container');
  if( 'CSR' == leave_option )
  {
    $csr_container.removeClass("hide");
    $("#leave-type-form-group").addClass("hide");
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
  }
  else{
    if('' == leave_option){
      $csr_container.addClass("hide");
      $("#leave-type-form-group").addClass("hide");
    }
    else{
      $csr_container.addClass("hide");
      $("#leave-type-form-group").removeClass("hide");
    }
    
  }
});


$('#leave_type').on('change',function(e){

  var leave_type = $(this).val();
  $csr_container = $('#csr-container');
  if( 'CSR' == leave_type )
  {
    $csr_container.removeClass("hide");
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
    
  }
  else if( "LEAVE" == leave_type || "FH" == leave_type || "SH" == leave_type)
  {
    $csr_container.removeClass("show").addClass("hide");
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
  }
  else if("LONG" == leave_type){
    $("#date-control").removeClass("date-single").removeClass("date-multiple").addClass("date-long");
  }
  else{
    $("#date-control").removeClass("date-single").addClass("date-multiple").removeClass("date-long");
  }
  if($(".date_control").hasClass("date-long")){
    $(".date-long").multiDatesPicker({
      maxPicks: 2,
      showOn : "both",
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0"
    });
  }
  else if($(".date_control").hasClass("date-multiple")){
    $(".date-multiple").multiDatesPicker({
      maxPicks: 10,
      showOn : "both",
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0"
    });
  }
  else{
    $(".date_control").multiDatesPicker({
      maxPicks: 1,
      showOn : "both",
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0"
    });
  }
  $("#date-control").val('');
  $("#date-control").multiDatesPicker('resetDates');

});





$(document).on("ready",function(){
  if($("#addSlot").length == 1){
    if($("#timeSlot").find(".row.form-group").length == 2)
    {
      $("#addSlot").remove();
    }
    window.timeSlotHtml = $('#timeSlot').find(".row.form-group").last().html();
    $('#addSlot').on('click', function(e){
      var slotCount = $("#timeSlot").find(".row.form-group").length.toString();
      $('#timeSlot').append("<div class='row form-group has-feedback'></div>")
      $('#timeSlot .row.form-group:last').append(window.timeSlotHtml);
      $("#timeSlot").find(".row.form-group").last().find('input').each(function() {
        $name = $(this).attr('name');
        $name = $name.replace(/[0-9]+/g,slotCount);
        $(this).attr("name",$name);
      });
      if($("#timeSlot").find(".row.form-group").length == 2)
      {
        $("#addSlot").remove();
      }
      $('.timepicker').timepicker({
        minuteStep: 5,
        showInputs: true,
        disableFocus: true,
        defaultTime: false
      });
    });
  } 
});



$(document).on("ready",function(){
  // applies multiselect
  if( $('.multiselect').length !== 0)
  {
    $('.multiselect').multiselect(
    { enableFiltering: true,
    filterBehavior : 'text',
    enableCaseInsensitiveFiltering: true
    }
    );
  }
  var leave_type = $('#leave_type');
  if( 'CSR' == leave_type )
  {
    $csr_container.removeClass("hide").addClass("show");
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
    
  }
  else if( "LEAVE" == leave_type || "FH" == leave_type || "SH" == leave_type)
  {
    $csr_container.removeClass("show").addClass("hide");
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
  }
  else if("LONG" == leave_type){
    $("#date-control").removeClass("date-single").removeClass("date-multiple").addClass("date-long");
  }
  else{
    $("#date-control").removeClass("date-single").addClass("date-multiple").removeClass("date-long");
  }
  
 if( $(".date_control").length !==0 )
 {
    $(".date_control").each(function(){
      var $date_control =   $(this);
      var date_control_val = $date_control.val().split(" ")[0];
      
      if($(".date_control").hasClass("date-long")){
        var dts = [];
        if(date_control_val == ""){
          $date_control.multiDatesPicker({
            maxPicks: 2,
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
          });
        }
        else{
          $.each(date_control_val.split(","),function(k,v){
            dts.push(new Date(v.split('-')[0], parseInt(v.split('-')[1]) - 1, v.split('-')[2]));
          });
          $date_control.multiDatesPicker({
            maxPicks: 2,
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            addDates: dts
          });
        }
  
      }
      else if($(".date_control").hasClass("date-multiple")){
        var dts = [];
        if(date_control_val == ""){
          $date_control.multiDatesPicker({
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
          });
        }
        else{
          $.each(date_control_val.split(","),function(k,v){
            dts.push(new Date(v.split('-')[0],parseInt(v.split('-')[1]) - 1, v.split('-')[2]));
          });
          $date_control.multiDatesPicker({
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            addDates: dts
          });
        }
      }
      else{
        var dt;
        if(date_control_val == ""){
          $date_control.multiDatesPicker({
            maxPicks: 1,
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
          });
        }
        else{
          dt = new Date(date_control_val.split("-")[0],parseInt(date_control_val.split("-")[1]) - 1,date_control_val.split("-")[2]);
          $date_control.multiDatesPicker({
            maxPicks: 1,
            showOn : "both",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            addDates: [dt]
          });
        }
        
      }
    })
  }

  if($('.multiple-select-with-checkbox').length != 0){
    $('.multiple-select-with-checkbox').each(function(){
      var options = $(this).find("option");
      var $selectbox = $(this); 
      var checkboxHtml = "<div class='row'><div class='col-lg-4'></div>";
      checkboxHtml += "<div class='col-lg-4'></div>";
      checkboxHtml += "<div class='col-lg-4'></div></div>";
      $selectbox.parent().append(checkboxHtml);
      var checkboxName = $selectbox.attr("name");
      options.each(function(k,v){
        currentRow = (k % 3) + 1;
        isChecked = $(this).is(":selected");
        $selectbox.parent().find("div.row").find("div:nth-child(" + currentRow + ")").append(getMultipleCheckboxHTML(checkboxName, $(this).val(), $(this).html(), isChecked));
      });
    });
    $('.multiple-select-with-checkbox').remove();
  }
  
  
  $(".delete-myleave").on("click", function(){
    var $this = $(this);
    var $parentRow = $(this).closest("tr");
    if(confirm("Are you sure you want to delete this leave")){
      $.ajax({
        url: $(this).data("url"),
        type: "get",
        dataType: "json",
        success: function(retdata){
          $parentRow.remove();
        }
      });
    }
  });
});


$(document).on("submit", "#leaves_create_form, #leaves_edit_form",function(e){
  e.preventDefault();
  if($("#leave_option").val() === "CSR"){
    var slotsCount = ($("#timeSlot .timepicker").length / 2);
    switch(slotsCount){
      case 1:
        var startTime = $("#timeSlot .timepicker.start").first().val();
        var endTime = $("#timeSlot .timepicker.end").first().val();
        var diff = getHourDifference(startTime, endTime);
        if(diff < 0){
          alert("Invalid Date Range selected for CSR time inputs");
          return;
        }
        if(diff > 2){
          alert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
          return;
        }
        break;
      case 2:
        var startTime1 = $("#timeSlot .timepicker.start").first().val();
        var endTime1 = $("#timeSlot .timepicker.end").first().val();
        var startTime2 = $("#timeSlot .timepicker.start").last().val();
        var endTime2 = $("#timeSlot .timepicker.end").last().val();
        var diff = getHourDifference(startTime1, endTime1);

        if(diff < 0){
          alert("Invalid Date Range selected for CSR(1) time inputs");
          return;
        }
        if(diff > 2){
          alert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
          return;
        }
        var diff2 = getHourDifference(startTime2,endTime2);
        if(diff2 < 0){
          alert("Invalid Date Range selected for CSR(2) time inputs");
          return;
        }
        diff2 += diff;
        if(diff2 > 2){
          alert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
          return;
        }
        diff += diff2;
        break;
    }
  }
  if($(this).attr("id") == "leaves_create_form"){
    $("#leaves_create_form")[0].submit();
  }
  else{
    $("#leaves_edit_form")[0].submit();
  }
  
});


function getHourDifference(startTime, endTime){
  var sTime = new Date("10-12-1987 " + startTime);
  var eTime = new Date("10-12-1987 " + endTime);
  var diff = (eTime - sTime)/1000/60/60;
  return diff;
}

/*  reqVal may be hour, min
    and returns 24 hour format hour if reqVal is hour
*/

function getTimeInfo(reqVal,inputTime){
  switch(reqVal){
    case "hour":
      var hour = parseInt(inputTime.split(":")[0]);
      var meridian = inputTime.split(":")[1].split(" ")[1];
      if(meridian === "PM"){
        hour += 12;
      }
      else{
        hour = hour % 12;
      }
      return hour;
    case "min":
      return parseInt(inputTime.split(":")[1].split(" ")[0]);
  }
}



$(document).on('click','.approve-status-change', function (e) {
  var approvalStatus = $(this).data("approve_status");
  var approvalId = $(this).data("approval_id");
  var leaveId = $(this).data("leave_id");
  var data;
  if(typeof approvalId == "undefined"){
    data = {
      approvalStatus: approvalStatus,
      leaveId: leaveId
    }
  }
  else{
    data = {
      approvalStatus: approvalStatus,
      approvalId: approvalId
    }
  }
  var approvalUrl = $(this).data("approval_url");
  var $this = $(this);
  $.blockUI();
  $.ajax({
    type: 'post',
    url: approvalUrl,
    data: data,
    dataType: "json",
    success: function(data){
      if(approvalStatus == "YES"){
        $this.parent().html(getApprovedInfoHTML());
      }
      else{
        $this.parent().html(getRejectedInfoHTML());
      }
      $.unblockUI();
    }
  });
});

$(document).on('click', '.view-approvals', function(e){
  var url = $(this).data("url");
  $.ajax({
    url: url,
    type: "get",
    success: function(retdata){
      $("#user-modal .modal-title").text("Approval Status");
      $("#user-modal .modal-body").html(retdata);
      $("#user-modal").modal('show');
    }
  });
});

$(document).on('dblclick', ".editable", function(){
  console.log("i m here");
  $(this).prop("readonly",false);
});

$(document).on('blur', ".editable", function(){
  var url = $(this).data("url");
  var model = $(this).data("model");
  var column = $(this).data("column");
  var value = $(this).val();
  var id = $(this).data("id");
  var origVal = $(this).data("orig");
  var $this = $(this);
  $.blockUI();
  $.ajax({
    url: url,
    data: {model: model, column: column, value: value, id: id},
    dataType: "json",
    success: function(retdata){
      if(retdata.status == true){
        window.location.reload();
      }
      else{
        $this.val(origVal);
      }
      $.unblockUI();
    }
  })
  $(this).prop("readonly",true);
});

$(document).on('keyup', ".editable", function(e){
  if(e.keyCode == 13){
    var url = $(this).data("url");
    var model = $(this).data("model");
    var column = $(this).data("column");
    var value = $(this).val();
    var id = $(this).data("id");
    var origVal = $(this).data("orig");
    var $this = $(this);
    $.blockUI();
    $.ajax({
      url: url,
      data: {model: model, column: column, value: value, id: id},
      dataType: "json",
      success: function(retdata){
        if(retdata.status == true){
          window.location.reload();
        }
        else{
          $this.val(origVal);
        }
        $.unblockUI();
      }
    })
    $(this).prop("readonly",true);
  }
});








function getMultipleCheckboxHTML(name,key,val, checked){
  var checkboxinput_checked = "";
  if(checked == true){
    checkboxinput_checked = " checked";
  }
  return "<input type='checkbox' name='"+name+"' value='" + key +"' " + checkboxinput_checked + "/> <span class='checkbox-text'>" + val + "</span>&nbsp;&nbsp;";
}



function getApprovedInfoHTML(){
  return  '<a href="javascript: void(0);" class="btn btn-xs btn-primary approve-status-change btn-success">'+
            '<span class="glyphicon glyphicon-ok" title="Leave Approved"></span>'+
          '</a>'
}

function getRejectedInfoHTML(){
  return  '<a href="javascript: void(0);" class="btn btn-xs btn-primary approve-status-change btn-danger">'+
            '<span class="glyphicon glyphicon-remove btn-danger" title="Leave Rejected"></span>'+
	  '</a>';
}




