<?php

class admin_comments extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (($this->user->isAdmin()) && (q('admin/comments')))
			return 1;	// priority 1
		else return false;
	}
	
	function execute() {
		$data = $this->db->queryResults("SELECT room_id
								   FROM chatbox
								   GROUP BY room_id
								   ORDER BY room_id ASC");

		$this->addModel('box', $data);
		$this->addModel('prompt', 'message', '');
		$this->addModel('prompt', 'error', '');

		// chatbox
		$this->loadView('../plugins/chatbox/admin.comments.tpl');
	}
}

class admin_comment_del extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for admin/comments/del
		if (($this->user->isAdmin()) && (q('admin/comments/del/*')))
			return 1;	// priority 2
		else return false;
	}

	function execute() {
		$commentid = (int) q(3);
		$data = $this->db->query("DELETE FROM chatbox WHERE id=".$commentid.";");
		redirect('/admin/comments');
	}
}

// Register email
class chatbox_login extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// url pattern chatbox/register/username
		if (q('chatbox/register/*')) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		// cancel if chatuser is blank
		if (trim(q(2)) == '') return;
		
		// setter
		if (trim(q(2)) != '')
			$_SESSION['chatuser'] = q(2);
	}
}

// display chatlog of chatroom
class chat_log extends Controller {
	//chatbox/chatlog/room/last-post-id
	function validate() {
		// url pattern chatbox/chatlog/room/last-post-id
		if (q('chatbox/chatlog/*/*'))
			return 1;
		else 
			return false;
	}

	function execute() {
		
		// db prep
		$db = new Database();
		$db->connect();
		
		// url pattern: chatbox/chatlog/room/last-post-id
		$room_id = q(2);
		$last_post_id = (int) q(3);
		
		// get all chat posts from main lobby
		$data = $db->queryResults("SELECT id, liner, md5(user) picture, user email
								   FROM chatbox
								   WHERE room_id='".$db->param($room_id)."'
								   AND id > ".$last_post_id."
								   ORDER BY id DESC
								   LIMIT 50");

		if ($data != false) {
			// obtained new logs
			$data = array_reverse($data);
			
			// set to render with view
			$this->addModel('posts', $data);
			$this->loadView('../plugins/chatbox/post.ajax.tpl');
		}
	}
}

// post a new comment to a chatbox room
class chatbox_post extends Controller {
	// url pattern: chatbox/post/
	function validate() {
		// url pattern: chatbox/post/{room}/{liner}
		if (
			(isset($_SESSION['chatuser'])) &&
			(trim($_SESSION['chatuser']) != '') &&
			(q('chatbox/post/*/*'))
		) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		// db prep
		$db = new Database();
		$db->connect();
		
		// vars input
		$room_id = q(2);
		if (trim($room_id) == '') return;
		$liner = q(3);
		if (trim($liner) == '') return;
		
		// get all chat posts from main lobby
		$data = $db->query("INSERT INTO chatbox (room_id, liner, user)
							VALUES('".$db->param($room_id)."', '".$db->param($liner)."', '".$db->param($_SESSION['chatuser'])."');");
		
	}
}

class inject_chatbox extends Controller {
	
	function validate() {
		return 999;
	}
	
	function execute() {
			$room_id = 'main';
			$chatbox = '';

			$db = new Database();
			$db->connect();
			$data = $db->queryResults("SELECT liner, user
									   FROM chatbox
									   WHERE room_id='".$db->param($room_id)."'
									   ORDER BY id DESC
									   LIMIT 50;");
			if ($data == false) {
				
				// verify if database structure is complete.
				$struct_test = $db->queryResults("SELECT liner, user
										   FROM chatbox
										   LIMIT 1");

				//if structure is incomplete
				if ($struct_test == false) {
					// create it
					$obj = $db->query("CREATE TABLE IF NOT EXISTS `chatbox` (
											  `id` int(11) NOT NULL AUTO_INCREMENT,
											  `room_id` varchar(255) COLLATE latin1_general_ci NOT NULL,
											  `user` varchar(255) COLLATE latin1_general_ci NOT NULL,
											  `liner` varchar(255) COLLATE latin1_general_ci NOT NULL,
											  PRIMARY KEY (`id`)
											) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
											");
				}
				
			}
			
			$chatbox .= '<div class="chatbox">';
			$chatbox .= '<span class="title"><span style="color:#ffcccc;">@</span><span style="color:#ccccff;">chat</span><span style="color:#565758;">box</span></span>';

			$chatbox .= '<input type="hidden" name="room_id" class="room_id" value="'.$db->param($room_id).'">';

			if (isset($_SESSION['chatuser']))
				$append = 'style="display:none;"';
			else
				$append = '';
			$chatbox .= '<input class="noid" type="text" '.$append.' placeholder="email@provider.com" />';
				
				$chat_warmer = array();
				$chat_warmer[] = "How's that for a feature!";
				$chat_warmer[] = "IMHO...";
				$chat_warmer[] = "But there's a catch!";
				$chat_warmer[] = "Get in the fun.";
				$chat_warmer[] = "What would you recommend?";
				$chat_warmer[] = "I need a coffee before I think about this...";
				$chat_warmer[] = "My energy drink levels will determine that.";
				$chat_warmer[] = "That's cute.";
				$chat_warmer[] = "More often than not, yes.";
				$chat_warmer[] = "Yup, I'm serious!";
				$chat_warmer[] = "It's way too late to think of chat lines";
				$chat_warmer[] = "And here's the thing:";
				$chat_warmer[] = "C'est la vie.";
				$chat_warmer[] = "I had a dream last night";
				
				$keyin = array_rand($chat_warmer, 1);
				if (isset($_SESSION['chatuser']))
					$append = '';
				else
					$append = 'style="display:none;"';

				$chatbox .= '<textarea class="hasid" '.$append.' placeholder="'.$db->param($chat_warmer[$keyin], true).'"></textarea><a href="#" class="action hvr-radial-in">+</a>';
				
			$chatbox .= '</div>';

			
			$this->injectView('.chatterbox','append', $chatbox, '');
			$this->injectView('head', 'append', '<link rel="stylesheet" type="text/css" href="/webapp/plugins/chatbox/chatbox.css">', '');
			$this->injectView('head', 'append', '<script src="/webapp/plugins/chatbox/chatbox.js"></script>', '');
	}
}