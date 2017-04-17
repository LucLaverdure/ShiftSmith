var latest_post = [];

function getchatslive() {
	$('.chatbox').each(function() {
		var room = $(this).find('.room_id').last().val();
		var last_line = $(this).find('.line').last().attr('data-id');
		get_posts(room, last_line);
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
		$('.chatbox').find('input[value="'+room+'"]').parents('.chatbox').append(data);
		last_post_id = $('.chatbox').find('input[value="'+room+'"]').parents('.chatbox').find('line').attr('data-id');
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
			var room = $this.parents('.chatbox').find('.room_id').val();
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
			var room = $this.parents('.chatbox').find('.room_id').val();
			write_post(room, $(this).parents('.chatbox').find('.hasid').val());
			$(this).parents('.chatbox').find('.hasid').val('')
			return false;
		}
		$(this).parents('.chatbox').find('.noid,textarea').val('');
		return false;
	});
	
	$(document).on('click', '.showhide', function() {
		var group = $(this).data('group');
		$("#"+group).toggle('slider');
		return false;
	});

$(function() {
	getchatslive();
});
		
	setInterval(function(){
		//code goes here that will be run every 5 seconds.    
		//chatbox/chatlog/room/last-post-id
		getchatslive();
	},5000);