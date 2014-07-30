var socket = io('http://lms-node.herokuapp.com');

// $(document).on("click", "#notify_others", function(){
// 	socket.emit("notify_others", {"sender" : "naresh", "text" : parseInt(Math.random() * 10)})
// });

// socket.on("notified", function(data){
// 	$("#my_notification").html(data.text)
// });

$(document).on("ready", function(){
	if(typeof notification_data != "undefined"){
		var notification_name = notification_data["noti_name"];
		var notification_getter = notification_data["noti_getter"];
		socket.emit(notification_name, {"notification_getter" : notification_getter});
	}
});

socket.on("notify_approver", function(data){
	if($.inArray(current_user_id, data.notification_getter) != -1){
		var pending_request_count = parseInt($("#pending-request-count").html());
		pending_request_count += 1;
		$("#pending-request-count").html(pending_request_count);
		var notification_method;
		if(typeof data.message != undefined){
			notification_method = data.message;
		}
		else{
			notification_method = "One new leave request Arrived";
		}
		notification_html = '<div class="row">' + 
      '<div class="col-sm-12">'+notification_method+'</div>' + 
    '</div>';
    if($(".notification").length == 0){
    	notification_html_outer = getNotificationHtmlOuter();
    	$("#content-panel").prepend(notification_html_outer);
    }
    $(".notification").append(notification_html);
    if($(".notification").hasClass("hide")){
    	$(".notification").removeClass("hide");
    }
	}
});

socket.on("notify_applier", function(data){
	if($.inArray(current_user_id, data.notification_getter) != -1){
		var notification_method;
		if(typeof data.message != undefined){
			notification_method = data.message;
		}
		else{
			notification_method = "One of your leaves has been approved";
		}
		notification_html = '<div class="row">' + 
      '<div class="col-sm-12">'+notification_method+'</div>' + 
    '</div>';
    if($(".notification").length == 0){
    	notification_html_outer = getNotificationHtmlOuter();
    	$("#content-panel").prepend(notification_html_outer);
    }
    $(".notification").append(notification_html);
    if($(".notification").hasClass("hide")){
    	$(".notification").removeClass("hide");
    }
	}
});

function getNotificationHtmlOuter(){
	return '<div class="alert alert-info alert-dismissible notification hide">' + 
    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' + 
  '</div>';
}