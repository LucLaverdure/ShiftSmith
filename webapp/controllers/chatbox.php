<?php

// Register email
class chatbox_login extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// url pattern chatbox/register/username
		if ((q('0')=="chatbox") && (q(1)=='register')) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		// cancel if chatuser is blank
		if (trim(q(2))=='') return;
		
		// setter
		if (trim(q(2)) != "")
			$_SESSION['chatuser'] = q(2);
	}
}

// display chatlog of chatroom
class chat_log extends Controller {
	//chatbox/register/username
	function validate() {
		// url pattern chatbox/chatlog/room/last-post-id
		if ((q('0')=="chatbox") && (q(1)=="chatlog"))
			return 1;
		else 
			return false;
	}
	
	// get latest views in asc order
	function prioritySorterB($a, $b) {
		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	function execute() {
		
		// db prep
		$db = new Database();
		$db::connect();
		
		// url pattern: chatbox/chatlog/room/last-post-id
		$room_id = q(2);
		$last_post_id = (int) q(3);
		
		// get all chat posts from main lobby
		$data = $db::queryResults("SELECT id, liner, md5(user) picture, user email
								   FROM chatbox
								   WHERE room_id='".$db::param($room_id)."'
								   AND id > ".$last_post_id."
								   ORDER BY id DESC
								   LIMIT 50");

		if ($data != false) {
			// obtained new logs
			$data = array_reverse($data);
			
			// set to render with view
			$this->addModel('posts', $data);
			$this->loadView('default-theme/post.ajax.tpl');
		}
	}
}

// post a new comment to a chatbox room
class chatbox_post extends Controller {
	// url pattern: chatbox/post/
	function validate() {
		// url pattern: post/chatbox/room/liner
		if ((isset($_SESSION['chatuser']) &&
		(trim($_SESSION['chatuser']) != '') &&
		(q('0')=="chatbox") &&
		(q(1)=="post"))
		) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		// db prep
		$db = new Database();
		$db::connect();
		
		// vars input
		$room_id = q(2);
		if (trim($room_id)=='') return;
		$liner = q(3);
		if (trim($liner)=='') return;
		
		// get all chat posts from main lobby
		$data = $db::query("INSERT INTO chatbox (room_id, liner, user)
							VALUES('".$db::param($room_id)."', '".$db::param($liner)."', '".$_SESSION['chatuser']."');");
	}
}
