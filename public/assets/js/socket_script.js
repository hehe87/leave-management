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
	console.log(data.notification_getter);
	if($.inArray(current_user_id, data.notification_getter) != -1){
		var pending_request_count = parseInt($("#pending-request-count").html());
		pending_request_count += 1;
		$("#pending-request-count").html(pending_request_count);
	}
});