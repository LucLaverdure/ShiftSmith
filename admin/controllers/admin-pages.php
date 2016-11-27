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
		if (isset($_SESSION['login']) && ((q('0')=='admin') || q(1)=='dreamforgery'))
			return 1;	// priority 2
		else return false;
		return false;
	}
	
	function execute() {
		
		$this->cacheForm('page_admin', array('title'=>'', 'html'=>'', 'lang'=>'en'));

		// media gallery
		$this->loadView('admin.dreamforgery.tpl');
	}
}
