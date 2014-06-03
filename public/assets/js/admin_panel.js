$(document).on("ready",function(){
  $(".date_control").datepicker({
    showOn : "button",
    dateFormat: "yy-mm-dd"
  });
  
  $(".date_control").each(function(){
    $(this).val($(this).val().split(" ")[0]);
  });
  
});

$(document).on("click",".glyphicon-calendar", function(){
  $(this).prev(".ui-datepicker-trigger").click();
});


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