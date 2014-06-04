// Initialize the datatables
$('#leavesTable').DataTable();

// update leave request status
$('.approved').on('change', function (e) {

	$.ajax({
	type: 'POST',
	url: 'update-status',
	data: $(this).closest('form').serialize(),
	success: function(data){
		return true;
	},
});

});