/**
  Page Name:                        common.js
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page contains javascript used in admin or user panels
  Table referred:		    -
  Table updated:	            -
  Most Important Related Files:     -
*/

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
      $('#timeSlot').append("<div class='row form-group'></div>")
      $('#timeSlot .row.form-group:last').append(window.timeSlotHtml);
      $("#timeSlot").find(".row.form-group").last().find('select').each(function() {
        $name = $(this).attr('name');
        $name = $name.replace(/[0-9]+/g,slotCount);
        $(this).attr("name",$name);
      });
      if($("#timeSlot").find(".row.form-group").length == 2)
      {
        $("#addSlot").remove();
      }
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
      
      console.log(date_control_val);
      
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
            console.log(v);
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
    
  ////applies datepicker on date_control class
  //$(".date_control").datepicker({
  //  showOn : "both",
  //  dateFormat: "yy-mm-dd",
  //  changeMonth: true,
  //  changeYear: true,
  //  yearRange: "-100:+0"
  //});
  //
  ////removes time part from date_control input value
  //$(".date_control").each(function(){
  //  if($(this).val() != ""){
  //    $(this).val($(this).val().split(" ")[0]);
  //  }
  //});
  
  
  
  // update leave request status
  $('.approve-status-change').on('click', function (e) {
    var approvalStatus = $(this).data("approve_status");
    var approvalId = $(this).data("approval_id");
    var approvalUrl = $(this).data("approval_url");
    var $this = $(this);
    $.ajax({
      type: 'post',
      url: approvalUrl,
      data: {approvalStatus: approvalStatus, approvalId: approvalId},
      dataType: "json",
      success: function(data){
        if(approvalStatus == "YES"){
          $this.parent().html(getApprovedInfoHTML());
        }
        else{
          $this.parent().html(getRejectedInfoHTML());
        }
      }
    });
  });
  
  $('.view-approvals').on('click', function(e){
    var url = $(this).data("url");
    $.ajax({
      url: url,
      type: "get",
      success: function(retdata){
        $("#user-modal .modal-title").text("Your Leave Approvals");
        $("#user-modal .modal-body").html(retdata);
        $("#user-modal").modal('show');
      }
    });
  });
  
  
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
        type: "post",
        dataType: "json",
        success: function(retdata){
          $parentRow.remove();
        }
      });
    }
  });
  
 
  
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




