/**
  Page Name:                        common.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin or user panels
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/


// Tooltip on Anchors
$('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'bottom',
});
(function ( $ ) {
  $.blockUI =  function(){
    $("#blockUI").removeClass("hide");
  };
  $.unblockUI = function(){
    $("#blockUI").addClass("hide");
  };
}( jQuery ));

if(($(".in_time").length == 1) && $(".in_time").val() == ""){
  $(".in_time").val("09:30 AM");
}
if(($(".out_time").length == 1) && $(".out_time").val() == ""){
  $(".out_time").val("09:30 AM");
}



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
    $("#date-control").addClass("date-multiple").removeClass("date-single").removeClass("date-long");
  }
  if($(".date_control").hasClass("date-long")){
    $(".date-long").multiDatesPicker({
      maxPicks: 2,
      showOn : "both",
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0"
    });
  }
  else if($(".date_control").hasClass("date-multiple")){
    $(".date-multiple").multiDatesPicker({
      maxPicks: 10,
      showOn : "both",
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0"
    });
  }
  else{
    $(".date_control").multiDatesPicker({
      maxPicks: 1,
      showOn : "both",
      dateFormat: "dd-mm-yy",
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
    $("#date-control").addClass("date-single").removeClass("date-multiple").removeClass("date-long");
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
            dateFormat: "dd-mm-yy",
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
            dateFormat: "dd-mm-yy",
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
            dateFormat: "dd-mm-yy",
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
            dateFormat: "dd-mm-yy",
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
            dateFormat: "dd-mm-yy",
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
            dateFormat: "dd-mm-yy",
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
    jConfirm("Are you sure you want to delete this leave", "Confirmation", function(r){
      if(r){
        $.blockUI();
        $.ajax({
          url: $this.data("url"),
          type: "get",
          dataType: "json",
          success: function(retdata){
            $parentRow.remove();
            $.unblockUI();
          }
        });
      }
    });
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
          jAlert("Invalid Date Range selected for CSR time inputs");
          return;
        }
        if(diff > 2){
          jAlert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
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
          jAlert("Invalid Date Range selected for CSR(1) time inputs");
          return;
        }
        if(diff > 2){
          jAlert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
          return;
        }
        var diff2 = getHourDifference(startTime2,endTime2);
        if(diff2 < 0){
          jAlert("Invalid Date Range selected for CSR(2) time inputs");
          return;
        }
        diff2 += diff;
        if(diff2 > 2){
          jAlert("Please select CSR intervals so that the total CSR time will be less than 2 Hours");
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
      if(typeof data != "undefined" && typeof data.status != "undefined" && data.status == true){
        if(data.fully_approved){
          var leave_user_id = data.leave_user_id;
          console.log(leave_user_id);
          notification_data = {
            "noti_name" : "leave_approved",
            "notification_getter" : [leave_user_id]
          };
          if(typeof socket != "undefined"){
            socket.emit("leave_approved", notification_data)
          }
        }
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
          jAlert('Alert', 'Carry forward cannot be more than 5', function(){

          $this.val(origVal);
        });
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




// new add leave/csr js

function timingsContainersDisplay(hideOrShow){
  inOutTimeContainerDisplay(hideOrShow);
  availabilitySlotContainerDisplay(hideOrShow);
}

function inOutTimeContainerDisplay(hideOrShow){
  if(hideOrShow == "hide"){
    $(".in-out-time-container").hide();
  }
  else{
    $(".in-out-time-container").show(); 
  }
  
}

function availabilitySlotContainerDisplay(hideOrShow){
  if(hideOrShow == "hide"){
    $(".availablity-time-slot-container").hide();
  }
  else{
    $(".availablity-time-slot-container").show(); 
  }
}



var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('.from_dt').datepicker({
  format: "dd-mm-yyyy",
  onSelect: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate());
    checkout.setValue(newDate);
    timingsContainersDisplay("hide");
  }
  else{
    var coVal;
    if($.trim($('.to_dt').val()) == ""){
      coVal = $('.from_dt').val();
      timingsContainersDisplay("show");
    }
    else{
      coVal = $('.to_dt').val();
      if($.trim($('.to_dt').val()) == $.trim($('.from_dt').val())){
        timingsContainersDisplay("show");
      }
      else{
        timingsContainersDisplay("hide");
      }
      
    }
    checkout.setValue(coVal);
  }
  checkin.hide();
  // $('.to_dt')[0].focus();
}).data('datepicker');
var checkout = $('.to_dt').datepicker({
  format: "dd-mm-yyyy",
  onRender: function(date) {
    return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  var coVal;
  if($.trim($('.to_dt').val()) == $.trim($('.from_dt').val())){
    // if from date and to date are same
    timingsContainersDisplay("show");
  }
  else{
    // if from date and to date are different
    timingsContainersDisplay("hide");
  }
}).data('datepicker');

$(document).on("focus", ".from_dt", function(){
  checkout.hide();
});
$(document).on("focus", ".to_dt", function(){
  checkin.hide();
});



window.current_user = {};
window.current_user.lunch_break_start_time = moment($("#input-lunch-break-start-time").val(),"hh:mm A");
window.current_user.lunch_break_end_time = moment($("#input-lunch-break-end-time").val(),"hh:mm A");
window.current_user.lunch_break_hour_diff = window.current_user.lunch_break_end_time.diff(window.current_user.lunch_break_start_time,"minutes") / 60;
window.current_user.break_1_start_time = moment($("#input-break-start-time-1").val(),"hh:mm A");
window.current_user.break_1_end_time = moment($("#input-break-end-time-1").val(),"hh:mm A");
window.current_user.break_2_start_time = moment($("#input-break-start-time-2").val(),"hh:mm A");
window.current_user.break_2_end_time = moment($("#input-break-end-time-2").val(),"hh:mm A");
window.current_user.break_1_hour_diff = window.current_user.break_1_end_time.diff(window.current_user.break_1_start_time, "minutes") / 60;
window.current_user.break_2_hour_diff = window.current_user.break_2_end_time.diff(window.current_user.break_2_start_time, "minutes") / 60;
window.current_user.break_1_slot = [window.current_user.break_1_start_time, window.current_user.break_1_end_time];
window.current_user.break_2_slot = [window.current_user.break_2_start_time, window.current_user.break_2_end_time];

function isSlotInsideTimes(timeStart, inBetweenSlot , timeEnd){
  if((timeStart <= inBetweenSlot[0]) && (timeEnd >= inBetweenSlot[1])){
    return true;
  }
  return false;
}

// exclusive check (timeBetween is not included in timeStart and timeEnd)
function isTimeBetweenTimes(timeStart, timeBetween, timeEnd){
  if((timeStart < timeBetween) && (timeEnd > timeBetween)){
    return true;
  }
  return false;
}



function changeUserInOutTime(){
  window.current_user.inTime = $("#in-time").val();
  window.current_user.inTimeObj = moment(window.current_user.inTime, "hh:mm A");
  window.current_user.outTime = $("#out-time").val();
  window.current_user.outTimeObj = moment(window.current_user.outTime, "hh:mm A");  
  window.current_user.inTimeMinutes = window.current_user.inTimeObj.hours() * 60 + window.current_user.inTimeObj.minutes();

  if(typeof window.current_user.hourDiff != "undefined"){
    window.current_user.outTimeMinutes = window.current_user.inTimeMinutes + window.current_user.minuteDiff;
    var outHour = Math.floor((window.current_user.outTimeMinutes / 60) % 12);
    var outMin = window.current_user.outTimeMinutes % 60;
    if(outHour.toString().length == 1) outHour = "0" + outHour;
    if(outMin.toString().length == 1) outMin = "0" + outMin;
    $("#out-time").val(outHour + ":" + outMin + " PM");
    window.current_user.outTime = $("#out-time").val();
  }
  else{
    window.current_user.outTimeMinutes = window.current_user.outTimeObj.hours() * 60 + window.current_user.outTimeObj.minutes();
  }

  window.current_user.minuteDiff = window.current_user.outTimeMinutes - window.current_user.inTimeMinutes;
  window.current_user.hourDiff = window.current_user.minuteDiff / 60;
 
  window.current_user.inBetweenHours = [];

  for(i=window.current_user.inTimeMinutes+60;true;i+=60){
    var ampm = "";
    var tmpHour = Math.floor((i / 60));
    if(tmpHour > 12){
      tmpHour = tmpHour % 12;
      ampm = "PM";
    }
    else{
      ampm = "AM";
    }
    var tmpMin = i % 60;
    if(tmpHour.toString().length == 1) tmpHour = "0" + tmpHour;
    if(tmpMin.toString().length == 1) tmpMin = "0" + tmpMin;
    window.current_user.inBetweenHours.push(tmpHour + ":" + tmpMin + " " + ampm);
    if(window.current_user.hourDiff == 9.5){
      console.log(i);
      console.log(window.current_user.outTimeMinutes);
      if(i>=(window.current_user.outTimeMinutes - 30)){
        break;
      }
    }
    else{
      if(i >= (window.current_user.outTimeMinutes - 60)){
        break;
      }
    }
  }
  if(window.current_user.hourDiff == 9.5){
    $(".in-between-hours").removeClass("slot_9").addClass("slot_95");
  }
  else{
    $(".in-between-hours").addClass("slot_9").removeClass("slot_95");
  }

}

$(document).on("ready", function(){
  $("#in-time").on("change", function(){
    changeUserInOutTime();
    $("#from-time").html(window.current_user.inTime);
    $("#to-time").html(window.current_user.outTime);
    var inBetweenHoursHtml = "";
    $(window.current_user.inBetweenHours).each(function(){
      inBetweenHoursHtml += "<div><span class='slot-time-value'>" + this + "</span><span class='slotline'></span></div>";
    })
    $(".in-between-hours").html(inBetweenHoursHtml);
    
    if($.trim($(".slider").html()) != ""){
      $(".slider").html("");
    }
    $(".slider").slider({
      range: true,
      min: window.current_user.inTimeMinutes,
      max: window.current_user.outTimeMinutes,
      step: 5,
      value: [window.current_user.inTimeMinutes,window.current_user.inTimeMinutes],
      handle: "round"
    }).on("slide", function(ui) {
      var rangeStart = ui.value[0];
      var rangeEnd = ui.value[1];
      var rangeStartHours = Math.floor(rangeStart / 60);
      var rangeStartMinutes = rangeStart - (rangeStartHours * 60);

      var rangeEndHours = Math.floor(rangeEnd / 60);
      var rangeEndMinutes = rangeEnd - (rangeEndHours * 60);


      var ampm = "AM";
      if(rangeStartHours >= 12){
        if(rangeStartHours != 12){
          rangeStartHours = rangeStartHours % 12;
        }
        if(rangeStartHours.toString().length == 1) rangeStartHours = '0' + rangeStartHours;
        if(rangeStartMinutes.toString().length == 1) rangeStartMinutes = '0' + rangeStartMinutes;
        ampm = "PM";
      }
      else{
        if(rangeStartHours.toString().length == 1) rangeStartHours = '0' + rangeStartHours;
        if(rangeStartMinutes.toString().length == 1) rangeStartMinutes = '0' + rangeStartMinutes;
        ampm = "AM";
      }
      rangeStart = rangeStartHours + ":" + rangeStartMinutes + " " + ampm;


      if(rangeEndHours >= 12){
        if(rangeEndHours != 12){
          rangeEndHours = rangeEndHours % 12;
        }
        if(rangeEndHours.toString().length == 1) rangeEndHours = '0' + rangeEndHours;
        if(rangeEndMinutes.toString().length == 1) rangeEndMinutes = '0' + rangeEndMinutes;  
        ampm = "PM";
      }
      else{
        if(rangeEndHours.toString().length == 1) rangeEndHours = '0' + rangeEndHours;
        if(rangeEndMinutes.toString().length == 1) rangeEndMinutes = '0' + rangeEndMinutes;
      }
      rangeEnd = rangeEndHours + ":" + rangeEndMinutes + " " + ampm;
      
      

      $('.tooltip-inner').html(rangeStart + " - " + rangeEnd);
      $("#from-time").html(rangeStart);
      $("#to-time").html(rangeEnd);
      $("#input-from-time").val(rangeStart);
      $("#input-to-time").val(rangeEnd);
    });

    $('.tooltip-inner').html(window.current_user.inTime + " - " + window.current_user.outTime);
    changeUserInOutTime();
  });
  $("#in-time").change();

  $("#leave_apply").on("click", function(){
    var fromDate = $(".from_dt").val();
    var toDate = $(".to_dt").val();
    var fromDateObj;
    var toDateObj;
    var leaveType = "LEAVE";
    var leaveData = {};
    leaveData["from_date"] = fromDate;
    leaveData["to_date"] = toDate;
    if($.trim(fromDate) == ""){
      jAlert("Please select From Date");
    }
    else{
       fromDateObj = moment(fromDate, "DD-MM-YYYY");
    }
    if(($.trim(toDate) != "")){
      toDateObj = moment(toDate, "DD-MM-YYYY");
    }
    var diffDays = toDateObj.diff(fromDateObj, "days");
    var leaveDays = diffDays + 1;
    if(leaveDays > 1){
      leaveType = "LONG";
    }
    else{
      var fromt = $("#input-from-time").val();
      var tot = $("#input-to-time").val();
      var fromtObj = moment(fromt, "hh:mm A");
      var totObj = moment(tot, "hh:mm A");


      if((isTimeBetweenTimes(window.current_user.break_1_start_time, totObj, window.current_user.break_1_end_time)) || (isTimeBetweenTimes(window.current_user.break_2_start_time, totObj, window.current_user.break_2_end_time))){
        jAlert("You have selected your out time between break hours");
        return;
      }

      if((isTimeBetweenTimes(window.current_user.break_1_start_time, fromtObj, window.current_user.break_1_end_time)) || (isTimeBetweenTimes(window.current_user.break_2_start_time, fromtObj, window.current_user.break_2_end_time))){
        jAlert("You have selected your in time between break hours");
        return;
      }

      if(isTimeBetweenTimes(window.current_user.lunch_break_start_time, fromtObj, window.current_user.lunch_break_end_time)){
        jAlert("You have selected your in time between Lunch hours");
        return;
      }

      if(isTimeBetweenTimes(window.current_user.lunch_break_start_time, totObj, window.current_user.lunch_break_end_time)){
        jAlert("You have selected your out time between Lunch hours");
        return;
      }
      if(totObj.diff(fromtObj) == 0){
        leaveType = "LEAVE";
      }
      else{
        var inHours = totObj.diff(fromtObj,"minutes") / 60;
        var outHours = window.current_user.hourDiff - inHours;
        if(outHours <= 2){
          jAlert("Your Out Time is approximately 2 Hours, Please fill the CSR form instead");
          return;
        }
        // var inHours;
        // var outHours;
        if(isSlotInsideTimes(fromtObj, [window.current_user.break_1_start_time,window.current_user.break_1_end_time], totObj)){
          inHours -= window.current_user.break_1_hour_diff;
          console.log("break 1 is included in Slot")
        }

        if(isSlotInsideTimes(fromtObj, [window.current_user.break_2_start_time,window.current_user.break_2_end_time], totObj)){
          inHours -= window.current_user.break_2_hour_diff;
          console.log("break 2 is included in Slot")
        }

        if(isSlotInsideTimes(fromtObj, [window.current_user.lunch_break_start_time,window.current_user.lunch_break_end_time], totObj)){
          inHours -= window.current_user.lunch_break_hour_diff;
          console.log("lunch break is included in Slot")
        }


        console.log(inHours);
        if(inHours < 4)
        {
          leaveType = "LEAVE";
        }
        else{
          if((inHours >= 4) && (inHours < (window.current_user.hourDiff - 2))){
            if(fromtObj.diff(window.current_user.inTimeObj) < window.current_user.outTimeObj.diff(totObj)){
              leaveType = "SH";
            }
            else{
              leaveType = "FH";
            }
          }
          else{
            if(inHours == 0){
              leaveType = "LEAVE";
            }
            else{
              jAlert("Your Out Time is approximately 2 Hours, Please fill the CSR form instead");
              return;
            }
          }
        }      
      }
    }
    leaveData["leaveType"] = leaveType;
    leaveData["userOfficeInTime"] =  window.current_user.inTime;
    leaveData["userOfficeOutTime"] =  window.current_user.outTime;
    leaveData["userLeaveInTime"] = $("#input-from-time").val();
    leaveData["userLeaveOutTime"] = $("#input-to-time").val();
    var fullLeaveType = "";
    switch(leaveType){
      case "FH":
        fullLeaveType = "First Half";
        break;
      case "SH":
        fullLeaveType = "Second Half";
        break;
      case "LEAVE":
        fullLeaveType = "Full Day Leave";
        break;
      case "LONG":
        fullLeaveType = "Long Leave";
        break;
    }
    
    $(".modal-title").html("Leave Summary");
    var leaveSummaryBody = "";
    if(leaveDays > 1){
      // if user selected more than one day of leave(Long Leave)
      leaveSummaryBody += "<div class='row'>";
      leaveSummaryBody += "<label class='control-label col-sm-3'>";
      leaveSummaryBody += "Leave Type";
      leaveSummaryBody += "</label>";
      leaveSummaryBody += "<div class='col-sm-9'>";
      leaveSummaryBody += fullLeaveType;
      leaveSummaryBody += "</div>";
      leaveSummaryBody += "</div>";
      leaveSummaryBody += "<div class='row'>";
      leaveSummaryBody += "<label class='control-label col-sm-3'>From Date</label>";
      leaveSummaryBody += "<div class='col-sm-9'>" + fromDate + "</div>";
      leaveSummaryBody += "</div>";

      leaveSummaryBody += "<div class='row'>";
      leaveSummaryBody += "<label class='control-label col-sm-3'>To Date</label>";
      leaveSummaryBody += "<div class='col-sm-9'>" + toDate + "</div>";
      leaveSummaryBody += "</div>";

      leaveSummaryBody += "<div class='row'>";
      leaveSummaryBody += "<label class='control-label col-sm-3'>Total Days</label>";
      leaveSummaryBody += "<div class='col-sm-9'>" + (parseInt(toDateObj.diff(fromDateObj, "days")) + 1) + " Days</div>";
      leaveSummaryBody += "</div>";
      leaveData["leaveDays"] = (parseInt(toDateObj.diff(fromDateObj, "days") + 1));
    }
    else{
      // if user selected only one day leave
      if(fromtObj.diff(totObj) != 0){
        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>";
        leaveSummaryBody += "Leave Type";
        leaveSummaryBody += "</label>";
        leaveSummaryBody += "<div class='col-sm-9'>";
        leaveSummaryBody += fullLeaveType;
        leaveSummaryBody += "</div>";
        leaveSummaryBody += "</div>";
        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>Leave Date</label>";
        leaveSummaryBody += "<div class='col-sm-9'>" + fromDate + "</div>";
        leaveSummaryBody += "</div>";
        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>Out Time</label>";
        leaveSummaryBody += "<div class='col-sm-9'>";
        if(fromtObj.diff(window.current_user.inTimeObj) != 0){
          leaveSummaryBody += window.current_user.inTime + " To " + fromt;
          if(window.current_user.outTimeObj.diff(totObj) != 0){
            leaveSummaryBody += "<br>" + tot + " To " + window.current_user.outTime;
          }
        }
        else{
          leaveSummaryBody += tot + " To " + window.current_user.outTime;
        }

        leaveSummaryBody += "</div>";
        leaveSummaryBody += "</div>";

        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>Total In Time</label>";
        var inHoursShow = Math.floor(inHours);
        var inMinutesShow = Math.floor((inHours - inHoursShow) * 60);
        leaveSummaryBody += "<div class='col-sm-9'>" + inHoursShow + " Hours, " + inMinutesShow + " Minutes</div>";
        leaveSummaryBody += "</div>";
      }
      else{
        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>";
        leaveSummaryBody += "Leave Type";
        leaveSummaryBody += "</label>";
        leaveSummaryBody += "<div class='col-sm-9'>";
        leaveSummaryBody += fullLeaveType;
        leaveSummaryBody += "</div>";
        leaveSummaryBody += "</div>";


        leaveSummaryBody += "<div class='row'>";
        leaveSummaryBody += "<label class='control-label col-sm-3'>Leave Date</label>";
        leaveSummaryBody += "<div class='col-sm-9'>" + fromDate + "</div>";
        leaveSummaryBody += "</div>";
      }
    }
    
    

    $(".modal-body").html(leaveSummaryBody);
    if($("#confirm-leave").length == 0){
      $(".modal-footer").prepend('<button type="button" id="confirm-leave" class="btn btn-primary normal-button">Confirm</button>');
    }
    $("#confirm-leave").data("leaveData", leaveData);
    $(".modal").modal("show");
  });
});

$(document).on("click", "#confirm-leave", function(){
  var $this = $(this);
  $form = $("#leaves_create_form");
  url = $form.attr("action");
  data = $this.data("leaveData");
  data["approvals"] = $("#approval-select-box").val();
  data["leave_reason"] = $("#leave-reason").val();
  $.ajax({
    url: url,
    data: data,
    type: "post",
    success: function(retdata){
      if(retdata.status == true){
        window.location.href = "/leaves/myleaves";
      }
    }
  });
  $(".modal").modal("hide");
});
