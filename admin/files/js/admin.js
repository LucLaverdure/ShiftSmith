var image_gallery_timer;
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
	// setup all datepickers of the page
	$(".datepicker").datepicker();
	
	// select refresh rate of the chatboxes
	setTimeout(function() {$('.line').append('<span class="del"></span>'); },1000);

	//$('body').append('<div class="matrix"></div>').parent().append('<div class="moon"></div>').parent().append('<div class="hammer-lady"></div>').parent().append('<div class="luc-laverdure"></div>');

	var $this = $('a.media-image').not(':visible').first();
	if ($this.length > 0) {
		image_gallery_timer = setTimeout(function() {
			display_pictures();
		}, 600);
	}
	
	$('.admin-panel label a').click(function() {
		$(this).parent().find('input[type=radio]').click();
		return false;
	});
});

function display_pictures() {
	$this = $('a.media-image').not(':visible').first();
	$this.fadeIn();
	if ($this.length > 0) {
		image_gallery_timer = setTimeout(function() {
			display_pictures();
		}, 600);
	}
}


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

$(document).on('click', ".body_type label input", function(e) {
	var selected = $(this).val();

	switch (selected) {
		case 'markup':
			$('.markup-select').slideDown('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'url':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideDown('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'db':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideDown('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'drupal':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideDown('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'file':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideDown('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'wp-import':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideDown('fast');
			break;
		case 'drupal-import':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideDown('fast');
			$('.wp-select').slideUp('fast');
			break;
	}
	
});

