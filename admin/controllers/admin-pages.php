<?php

class view_page extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		
		$db = new Database();
		$db::connect();

		// get all triggers
		$data = $db::queryResults("SELECT `namespace`, `id`, `key`, `value`
								   FROM shiftsmith
								   WHERE namespace = 'trigger'
								   ORDER BY id DESC;");
		
		// when no triggers are found, cancel render
		if ($data == false) return false;
		
		// start 
		$verified = array();
		
		date_default_timezone_set("America/New_York");
		

		foreach ($data as $row) {

			if (!isset($verified[$row['id']])) {
				$verified[$row['id']] = 0;
			}

			// verify if date trigger is good
			if ( ($row['key'] == 'date') && (strtotime($row['value']) <= strtotime('now'))) {
				$verified[$row['id']]++;
			}

			// verify page type 
			if ( ($row['key'] == 'tag') && (($row['value'] == 'page') || ($row['value'] == 'blog') || ($row['value'] == 'block'))) {
				$verified[$row['id']]++;
			}
			
			// verify if url pattern is good
			if ( ($row['key'] == 'url') && ("/".q() == $row['value'])) {
				$verified[$row['id']]++;
			}
			
			// requires admin logged in or 
			if (isset($_SESSION['login']) && $row['key']=='admin_only' && $row['value']=='Y') {
				$verified[$row['id']]++;
			} else if ($row['value']=='N') {
				$verified[$row['id']]++;
			}

		}

		$valid_ids = array();

		foreach ($verified as $id => $count) {
			if ($count >= 4) {
				$valid_ids[] = $id;
			}
		}
		
		$this->addModel('ids', $valid_ids);
		
		if (count($valid_ids) > 0) {
			return 1;
		}
		
		return false;
	}
	
	function execute() {
		
		$db = new Database();
		$db::connect();

		$shiftsmith_ids = $this->getModel('ids');
		foreach ($shiftsmith_ids as $key => $id) {
			$shiftsmith[$key] = (int) $id;
		}

		// pages
		$pages = $db::queryResults("SELECT `id`, `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).");");

		foreach ($pages as $shift) {
			$this->addModel('page', $shift['key'], $shift['value']);
		}

		// posts
		$posts = $db::queryResults("SELECT `id`, `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).")
										AND id IN (SELECT id FROM shiftsmith WHERE `key`='tag' AND value='post');");

		if ($posts != false) {
			foreach ($posts as $shift) {
				$this->addModel('posts', $shift['key'], $shift['value']);
			}
		}
		
		// blocks
		$blocks = $db::queryResults("SELECT `id`, `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).")
										AND id IN (SELECT id FROM shiftsmith WHERE `key`='tag' AND value='block');");
		if ($blocks != false) {
			foreach ($blocks as $shift) {
				$this->addModel('blocks', $shift['key'], $shift['value']);
			}
		}

		// media gallery
		$this->loadView('default-theme/page.common.tpl');
	}
}


class admin_create_page extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']) && (q('0')=='admin') && q(1)=='shiftsmith')
			return 1;	// priority 2
		else return false;
	}
	
	function execute() {

		$init_shift = 0;
	
		$this->setModel('tags', array(array('name' => 'page')));

		$db = new Database();
		$db::connect();
		
		$this->cacheForm('page',
			array(
				'title' => "",
				'description' => "",
				'date' => "",
				'url' => "",
				'privatecheck' => "",
				'blogcheck' => '',
				'pagecheck' => 'checked="checked"',
				'inputHTMLCheck' => 'checked="checked"',
				'ckeditor' => "",
				'fetchMarkupURLCheck' => "",
				'urltofetch' => "",
				'selector' => "",
				'dbInCheck' => "",
				'dbInHost' => "",
				'dbInUser' => "",
				'dbInPassword' => "",
				'dbInName' => "",
				'dbInSQL' => "",
				'filesInCheck' => "",
				'DrupalInCheck' => "",
				'drupalInHost' => "",
				'drupalInUser' => "",
				'drupalInPassword' => "",
				'drupalInName' => "",
				'wpInHost' => "",
				'wpInUser' => "",
				'wpInPassword' => "",
				'wpInName' => "",
				'fetchOnceCheck' => 'checked="checked"',
				'fetchLiveCheck' => "",
				'adminInputCheck' => 'checked="checked"',
				'thirdPartyCheck' => "",
				'outputDBCheck' => 'checked="checked"',
				'outputFileCheck' => "",
				'outputDownloadCheck' => ""
			)
		);
		
		$title = '';
		$description = '';
		$tags = array();
		$content = '';
		$url = '';
		$date = '';
		$loggedasadmin = '';
		
		if (is_numeric(q(2))) {
			$id = (int) q(2);
			$data = $db::queryResults("select `key`, `value`
										from shiftsmith
										where id=".$id."
										;");
			if ($data) {
				foreach ($data as $key => $row) {
					$this->addModel('page', $row['key'], $row['value']);
				}
			}
			
			$tags = $db::queryResults("SELECT `value` as `name`
							FROM shiftsmith
							WHERE id=".$id."
							AND `key`= 'tag' AND `namespace` = 'trigger';");

			$this->addModel('tags', $tags);
			
		}
		
		

		if (isset($_POST['action']))
			$input_type = $db::param(strtolower(trim($_POST['action'])));
		else
			$input_type = "";
		
		if (in_array($input_type, array('blog', 'page', 'block'))) {
			$title = $db::param($_POST['title']);
			$description = $db::param($_POST['description']);
			$tags = $_POST['tagsDisplay'];

			$content = $db::param($_POST['body']);
			$url = $db::param($_POST['url']);
			$date = $db::param($_POST['date']);
			if (isset($_POST['loggedasadmin'])) {
				$loggedasadmin = 'Y';
				$this->addModel('page', 'privatecheck', 'checked="chceked"');
			} else {
				$loggedasadmin = 'N';
				$this->addModel('page', 'privatecheck', '');
			}
		} elseif ($input_type == 'download') {
			$files = $_POST['file'];
		}

		if (isset($_POST['output_type']))
			$output_type = $db::param(strtolower(trim($_POST['output_type'])));
		else
			$output_type = "";
		
		if ($output_type == 'database') {
				$init_shift = 1;
				$shiftroot = $db::queryResults("SELECT id
												FROM shiftsmith
												ORDER BY id DESC
												LIMIT 1;");

				if ($shiftroot == false) {
					$query = $db::query("CREATE TABLE IF NOT EXISTS `shiftsmith` (
										  `id` int(11) NOT NULL,
										  `namespace` varchar(255) COLLATE latin1_general_ci NOT NULL,
										  `key` varchar(255) COLLATE latin1_general_ci NOT NULL,
										  `value` text COLLATE latin1_general_ci NOT NULL,
										  KEY `id` (`id`,`namespace`,`key`)
										) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");
					$init_shift = 1;
				} else {
					if (is_numeric(q(2))) {
						$init_shift = (int) q(2);
					} else {
						$init_shift = $shiftroot[0]['id'] + 1;
					}
				}
				
				$insert_tags = '';
				foreach($tags as $tag) {
					$insert_tags .= ",(".$init_shift.", 'trigger', 'tag', '".$db::param($tag)."')";
				}

				// delete previous data
				if (is_numeric(q(2)) & isset($_POST['action'])) {
					$id = (int) q(2);
					$del_sql = "DELETE FROM `shiftsmith` WHERE `id`=".$id;
					$shiftroot = $db::query($del_sql);
				}
				
				//save new data
				$sql = "INSERT INTO shiftsmith (`id`, `namespace`, `key`, `value`) VALUES
											   (".$init_shift.", 'content', 'title', '".$title."'),
											   (".$init_shift.", 'content', 'description', '".$description."')
											   ".$insert_tags.",
											   (".$init_shift.", 'content', 'body', '".$content."'),
											   (".$init_shift.", 'trigger', 'url', '".$url."'),
											   (".$init_shift.", 'trigger', 'date', '".$date."'),
											   (".$init_shift.", 'trigger', 'admin_only', '".$loggedasadmin."')
											   ;";
				$shiftroot = $db::query($sql);

		}

		if (!is_numeric(q(2)) && isset($_POST['action'])) {
			redirect('/admin/shiftsmith/'.$init_shift);
		}
		
		$this->loadView('admin.shiftsmith.tpl');
	}
}