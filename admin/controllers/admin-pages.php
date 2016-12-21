<?php

class view_page extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		
		$db = new Database();
		$db::connect();

		$data = $db::queryResults("SELECT id, path
								   FROM dreamforgery
								   WHERE active='Y'
								   AND publish_date >= (NOW()+0)
								   ORDER BY order DESC;");
		$pages = array();
		if ($data != false) {
		foreach ($data as $dreamforgery) {
			if (inpath($dreamroot['path'])) {
				// add path to pass onto controller execution
				$pages[] = $dreamroot['id'];
			}
		}
		}

		
		$this->addModel('path_triggers', $pages);
		
		if (count($pages) > 0) return 1;
		else return false;
	}
	
	function execute() {
		
		$db = new Database();
		$db::connect();

		$dreamforgery_ids = $this->getModel('path', 'trigger');
		
		// dreamroot validated
		$dreamroot = $db::queryResults("SELECT dr.id, dr.path, dr.inject_path, dr.order, dr.template_path,
										dr.body, dr.title, dr.lang, dr.active, dr.publish_date
										FROM dreamforgery dr
										WHERE id IN('".implode(',',$dreamforgery_ids['id'])."');");
										
		$dreamroot = $db::queryResults("SELECT dt.id, 
										FROM dream_tag dt
										WHERE id='".$data['id']."';");

		$this->cacheForm($name, array('title'=>'', 'html'=>'', 'lang'=>'en'));

		addModel('box', $data);

		// media gallery
		$this->loadView('admin.create.page.tpl');
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

		$this->setModel('tags', array(array('name' => 'page')));
		$this->cacheForm('page',
			array(
				'title' => "",
				'description' => "",
				'date' => "",
				'urltrigger' => "",
				'privatecheck' => "",
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
		
		$this->loadView('admin.shiftsmith.tpl');
	}
}

class shiftsmith extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']) && (q('0')=='admin') && q(1)=='shiftsmith' && isset($_POST['body_type']))
			return 1;	// priority 2
		else return false;
	}
	
	function execute() {
		
		$title = $_POST['title'];
		$description = $_POST['description'];
		$body_type = $_POST['body_type'];
		$tags = explode(',', $_POST['tagsDisplay']);
		switch ($body_type) {
			case 'markup':
			
				break;
			case 'url':
				break;
			case 'db':
				break;
			case 'file':
				break;
			default:
				return;
		}

		$db = new Database();
		$db::connect();

		
	}
}
