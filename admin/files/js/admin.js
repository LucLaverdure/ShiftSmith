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
	$(".datepicker").datepicker();
	setTimeout(function() {$('.line').append('<span class="del"></span>'); },1000);
});


$(document).on('click', '.login-button', function() {
	$('#thisform').submit();
});

$(document).on('keypress', "#thisform input", function(e) {
	if (e.which == 13) {
		$('#thisform').submit();
		return false;
	}
});

$(document).on('click', ".fold-admin", function(e) {
	$('.admin-bar.left-bar').animate({
		left: -$('.admin-bar.left-bar').outerWidth(),
		opacity:0
	});
	$('.admin-bar.top-bar').animate({
		top: -$('.admin-bar.top-bar').outerHeight(),
		opacity:0
	});
	$('.unfold-admin').animate({
		top:0,
		left:0,
		opacity:0.8
	});
});

$(document).on('click', ".unfold-admin", function(e) {
	$('.admin-bar.left-bar').animate({
		left: 0,
		opacity:0.8
	});
	$('.admin-bar.top-bar').animate({
		top: 0,
		opacity:0.8
	});
	$('.unfold-admin').animate({
		top:'-100px',
		left:'-100px',
		opacity:0
	});
});
