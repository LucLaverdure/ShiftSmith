<?php

class admin_forge_page extends Controller {

	function validate() {
		if (isset($_SESSION['login']) && (q('0')=='admin') && ( q(1)=='create' || q(1)=='edit' ) && (q(2)=='page'))
			return 1;
		else return false;
	}
	
	function execute() {
		$init_shift = 0;
		
		$db = new Database();
		$db::connect();
		
		if (q(1)=='edit') {
			
			$id = (int) q(3);
			
			$data = $db::queryResults("SELECT `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id=".$id."
										ORDER BY `namespace`, `key`;");
										
			foreach ($data as $value) {
				$this->setModel('page', $value['key'], $value['value']);
			}
			
		} else {
			$this->cacheForm('page', array(
													'id' => '',
													'title' => '',
													'date' => '',
													'url' => '',
													'privatecheck' => '',
													'body' => ''
			));
		}
		
		$this->setModel('tags', array(array('name' => 'page')));
		
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');
				
		if (isset($_POST['title'])) {

			$init_shift = (int) $db::getShift();

			$this->setModel('page', 'id', $init_shift);
			
			$tags = $db::queryResults("SELECT `value` as `name`
										FROM shiftsmith
										WHERE id=".$init_shift."
										AND `key`= 'tag' AND `namespace` = 'trigger';");
			
			//save new data
			$title = $db::param($_POST['title']);
			$tags = $_POST['tagsDisplay'];
			$content = $db::param($_POST['body']);
			$url = $db::param($_POST['url']);
			$date = $db::param($_POST['date']);

			if (isset($_POST['private'])) {
				$loggedasadmin = 'Y';
				$this->addModel('page', 'privatecheck', 'checked="chceked"');
			} else {
				$loggedasadmin = 'N';
				$this->addModel('page', 'privatecheck', '');
			}

			$insert_tags = '';
			foreach($tags as $tag) {
				$insert_tags .= ",(".$init_shift.", 'trigger', 'tag', '".$db::param($tag)."')";
			}
				
			// delete previous data
			if (is_numeric($init_shift) & isset($_POST['action'])) {
				$id = (int) $init_shift;
				$del_sql = "DELETE FROM `shiftsmith` WHERE `id`=".$id;
				$shiftroot = $db::query($del_sql);
			}
			
			//save new data
			$sql = "INSERT INTO shiftsmith (`id`, `namespace`, `key`, `value`) VALUES
										   (".$init_shift.", 'content', 'title', '".$title."')
										   ".$insert_tags.",
										   (".$init_shift.", 'content', 'body', '".$content."'),
										   (".$init_shift.", 'trigger', 'url', '".$url."'),
										   (".$init_shift.", 'trigger', 'date', '".$date."'),
										   (".$init_shift.", 'trigger', 'admin_only', '".$loggedasadmin."')
										   ;";

			$shiftroot = $db::query($sql);

			$this->setModel('prompt', 'message', 'Page saved to database.');
		
			if (is_numeric($init_shift)) {
				redirect('/admin/edit/page/'.$init_shift);
			}
		}

		
		$this->loadView('admin.forge.page.tpl');
	}
}

class admin_forge_post extends Controller {

	
	function validate() {
		if (isset($_SESSION['login']) && (q('0')=='admin') && ( q(1)=='create' || q(1)=='edit' ) && (q(2)=='post'))
			return 1;
		else return false;
	}
	
	function execute() {
			
		$db = new Database();
		$db::connect();

		$this->cacheForm('page', array(
												'id' => '',
												'title' => '',
												'date' => '',
												'privatecheck' => '',
												'body' => ''
		));
		
		$this->setModel('tags', array(array('name' => 'post')));
		
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');
				
		if (isset($_POST['title'])) {

			$init_shift = $db::getShift();

			$tags = $db::queryResults("SELECT `value` as `name`
										FROM shiftsmith
										WHERE id=".$init_shift."
										AND `key`= 'tag' AND `namespace` = 'trigger';");
			
			//save new data
			$title = $db::param($_POST['title']);
			$tags = $_POST['tagsDisplay'];
			$content = $db::param($_POST['body']);
			$date = $db::param($_POST['date']);

			if (isset($_POST['private'])) {
				$loggedasadmin = 'Y';
				$this->addModel('page', 'privatecheck', 'checked="chceked"');
			} else {
				$loggedasadmin = 'N';
				$this->addModel('page', 'privatecheck', '');
			}

			$insert_tags = '';
			foreach($tags as $tag) {
				$insert_tags .= ",(".$init_shift.", 'trigger', 'tag', '".$db::param($tag)."')";
			}
				
			// delete previous data
			if (is_numeric($init_shift) & isset($_POST['action'])) {
				$id = (int) $init_shift;
				$del_sql = "DELETE FROM `shiftsmith` WHERE `id`=".$id;
				$shiftroot = $db::query($del_sql);
			}
			
			//save new data
			$sql = "INSERT INTO shiftsmith (`id`, `namespace`, `key`, `value`) VALUES
										   (".$init_shift.", 'content', 'title', '".$title."')
										   ".$insert_tags.",
										   (".$init_shift.", 'content', 'body', '".$content."'),
										   (".$init_shift.", 'trigger', 'date', '".$date."'),
										   (".$init_shift.", 'trigger', 'admin_only', '".$loggedasadmin."')
										   ;";

			$shiftroot = $db::query($sql);

			$this->setModel('prompt', 'message', 'Page saved to database.');
		
			if (!is_numeric($init_shift) && isset($_POST['action'])) {
				redirect('/admin/edit/page/'.$init_shift);
			}
		}

		
		$this->loadView('admin.forge.post.tpl');
	}
}