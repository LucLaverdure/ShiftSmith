<?php

class admin_comments extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*

		if (isset($_SESSION['login']) && ((q('0')=='admin') && q(1)=='comments'))
			return 1;	// priority 2
		else return false;
	}
	
	function execute() {
		
		$db = new Database();
		$db::connect();
		
		$data = $db::queryResults("SELECT room_id
								   FROM chatbox
								   GROUP BY room_id
								   ORDER BY room_id ASC");

		$this->addModel('box', $data);

		// chatbox
		$this->loadView('admin.comments.tpl');
	}
}

class admin_comment_del extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for admin/comments/del
		if (isset($_SESSION['login']) && (q('0')=='admin') && (q(1)=='comments') && (q(2)=='del') )
			return 1;	// priority 2
		else return false;
	}

	function execute() {
		global $main_path;
		
		$db = new Database();
		$db::connect();
		
		$commentid = q(3);
		$data = $db::query("DELETE FROM chatbox WHERE id='".$db::param($commentid)."';");
		echo "sucess";
		die();
	}
}
