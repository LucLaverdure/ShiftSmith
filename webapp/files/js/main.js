$(function() {
	$('.expand a').click(function() {
		$('.box').slideUp('fsat');
		$('.expand a').css('color', '#4286f4');
		$(this).css('color', '#005500').parent().next(':hidden').slideDown('fast');
		return false;
	});
	
	$('.parallax-window').parallax({imageSrc: $(this).data('image-src')});
	$(window).trigger('resize').trigger('scroll');
});
