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
    $csr_container.removeClass("hide").addClass("show");
  }
  
  else if( "LEAVE" == $leave_type )
  {
    $csr_container.removeClass("show").addClass("hide");
  }

});

$(document).on("ready",function(){
  if($("#addSlot").length == 1){
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
    });
  } 
});



$(document).on("ready",function(){
  
  //applies datepicker on date_control class
  $(".date_control").datepicker({
    showOn : "both",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    yearRange: "-100:+0"
  });
  
  //removes time part from date_control input value
  $(".date_control").each(function(){
    if($(this).val() != ""){
      $(this).val($(this).val().split(" ")[0]);
    }
  });
  
  
  
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
        console.log(approvalStatus);
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




