$(function() {
	$('.expand a').click(function() {
		$('.box').slideUp('fsat');
		$('.expand a').css('color', '#4286f4');
		$(this).css('color', '#005500').parent().next(':hidden').slideDown('fast');
		return false;
	});
	
	$('.parallax-window').parallax({imageSrc: '/files/img/AdobeStock_44069441.jpeg'});
	$(window).trigger('resize').trigger('scroll');
});
