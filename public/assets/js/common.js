$(".date_control").datepicker({"dateFormat" : 'yy-mm-dd'});

$('#leave_type').on('change', function(elem){
	$leave_type = $(this).val();
	$csr_container = $('#csr-container');
	
	if( 'CSR' == $leave_type )
	{
		$csr_container.show();
	}
	
	else if( "LEAVE" == $leave_type )
	{
		$csr_container.hide();
	}

});

$('#addSlot').on('click', function(e){
	$('#timeContainer').append($('#timeSlot').html());
});
