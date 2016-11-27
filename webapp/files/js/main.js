var latest_post = [];

function getchatslive() {
	$('.chatbox').each(function() {
		get_posts($(this).find('input[type="hidden"]').last().val(), $(this).find('.line').last().attr('data-id'));
	});
}
// register chat usernameregister chat username
function register_chat_user(email) {
	//chatbox/register/email
	$.ajax({
		url: "/chatbox/register/"+email,
		cache: false,
		context: document.body
	}).done(function() {
		// hide email box and show textarea box
		$('input.noid').fadeOut('');
		$('textarea.hasid').fadeIn('');
	});
}

// write post
function write_post(room, message) {
	// hide email box and show textarea box
	// post/chatbox/room/liner
	$.ajax({
		url: '/chatbox/post/'+room+'/'+message,
		cache: false,
		context: document.body
	}).done(function() {
		//success
		getchatslive();
	});
}


// get latest posts
function get_posts(room, last_post_id) {

	if ((typeof(last_post_id) == 'undefined') || last_post_id=='') last_post_id = 0;
	latest_post[room] = last_post_id;
	
	//chatbox/chatlog/room/last-post-id
	$.ajax({
		url: "/chatbox/chatlog/"+room+"/"+last_post_id,
		cache: false,
		context: document.body
	}).done(function(data) {
		$('.chatbox').find("input[value='"+room+"']").parents('.chatbox').append(data);
		last_post_id = $(this).parents('.chatbox').find('line').attr('data-id');
	});
}


$(function() {

	$('.expand a').click(function() {
		$('.box').slideUp('fsat');
		$('.expand a').css('color', '#4286f4');
		$(this).css('color', '#005500').parent().next(':hidden').slideDown('fast');
		return false;
	});
	
	if ($('.slider').length > 0) {
		$('.slider').unslider({
			animation: 'fade',
			autoplay: true,
			arrows: false,
			delay: 5000
		});
	}

	// slider
	if ($('.slider').length > 0) {
		$(document).on('click', '.noid,.hasid', function(e) {
			$('.slider').unslider('stop');
			return false;
		});
	}
	
	// email input
	$(document).on('keypress', '.noid', function(e) {
		if (e.which == 13) {
			register_chat_user($(this).val());
			return false;
		}
	});

	// text entry
	$(document).on('keypress', '.hasid', function(e) {
		$this = $(this);
		if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
			var room = $this.parents('.chatbox').find('input[type="hidden"]').val();
			write_post(room, $this.val());
			$(this).val('');
			return false;
		}
	});
	
	$(document).on('click', '.action', function() {
		$this = $(this);
		if ($(this).parents('.chatbox').find('.noid').is(':visible')) {
			register_chat_user($(this).parents('.chatbox').find('.noid').val());
		} else {
			var room = $(this).parents('.chatbox').find('input[type="hidden"]').val();
			write_post(room, $this.parents('.chatbox').find('input[type="hidden"]').val());
		}
		$(this).parents('.chatbox').find('input,textarea').val('');
		return false;
	});
	
	getchatslive();
	setInterval(function(){
		//code goes here that will be run every 5 seconds.    
		//chatbox/chatlog/room/last-post-id
		getchatslive();
	},5000);

});

