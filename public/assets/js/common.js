$(".date_control").datepicker({
  format: "yyyy-mm-dd"
});

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

$('#leave_date').datepicker({
  onRender: function(date) {
	//this line cause datepicker to hide partially
    //return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
});