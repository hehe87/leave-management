
/* $("#searchName").on("keyup", function(elem) {
	$search_text = $(this).val();
	$.get("leaves/search?name=" + $search_text, function($data){
		console.log($data);
	})
}); */

// Initialize the datatables
$('#leavesTable').DataTable();