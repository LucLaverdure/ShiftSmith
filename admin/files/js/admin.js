$(document).on('click', '.media-button .del', function() {
	
	var file_to_del = $(this).parents('a').attr('href');
	if (confirm("Are you sure you want to delete " + file_to_del + "?") == true) {
		window.location = '/admin/del'+file_to_del;
	} 
	
	return false;
});

$(document).on('click', '.line .del', function() {
	$.ajax({
		url: "/admin/comments/del/"+$(this).parents('.line').attr('data-id'),
		cache: false,
		context: document.body
	}).done(function(data) {
		$(this).parents('.line').fadeOut();
	});
});


$(function() {
	setTimeout(function() {$('.line').append('<span class="del"></span>'); },1000);
});
