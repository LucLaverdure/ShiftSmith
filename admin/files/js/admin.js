$(function() {
});

$(document).on('click', '.media-button .del', function() {
	
	var file_to_del = $(this).parents('a').attr('href');
	if (confirm("Are you sure you want to delete " + file_to_del + "?") == true) {
		window.location = '/admin/del'+file_to_del;
	} 
	
	return false;
});
