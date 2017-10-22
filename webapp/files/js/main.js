function adjustLeftCol() {
	if ($(".left-col").length > 0) {

		var get_top = ($(".parallax-window.sub").offset().top + $(".parallax-window.sub").outerHeight());
	
		var topla = get_top - $(document).scrollTop();
		if (topla < 0) topla = 0;
		if (topla > get_top) topla = get_top;
		$(".left-col").css('top', topla+'px');

		var h = $(window).height() - topla;
		if (h > $(window).height()) h = $(window).outerHeight();
		$(".left-col").css('height', h+'px');

	}
}

$(document).on('scroll', window, function() {
	adjustLeftCol();
});

$(document).on('resize', window, function() {
	adjustLeftCol();
});


$(function() {

	adjustLeftCol();
	
	$(".feature").mouseenter(function() {
		var r = $(this).attr('data-row');
		$(".feature").css('background', '#fff');
		$(".feature[data-row="+r+"]").css('background', '#dfd');
	});
	
	$('.expand a').click(function() {
		$('.box').slideUp('fsat');
		$('.expand a').css('color', '#4286f4');
		$(this).css('color', '#005500').parent().next(':hidden').slideDown('fast');
		return false;
	});		
	
	if ($('.slider').length > 0) {
		$('.slider').unslider({
			animation: 'fade',
			autoplay: false,
			arrows: false,
			delay: 2000
		});
	}

	// slider
	if ($('.slider').length > 0) {
		$(document).on('click', '.noid,.hasid', function(e) {
			$('.slider').unslider('stop');
			return false;
		});
	}

	// funk features
	//$('body').append($('<div class="matrix"></div><div class="moon"></div><div class="hammer-lady"><div class="luc-laverdure"></div>'));
});

