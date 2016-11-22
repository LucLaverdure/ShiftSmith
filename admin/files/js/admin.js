$(function() {
	$('.parallax-window').parallax({imageSrc: $(this).data('image-src')});
	$(window).trigger('resize').trigger('scroll');
});
