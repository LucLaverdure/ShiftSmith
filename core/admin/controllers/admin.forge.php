<?php

class admin_forge_lang extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && q('admin/create/lang'))
			return 1;
		else return false;
	}
	
	function execute() {
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		if (input('posting') != '') {
			// on page land, clear cache
			$langs = array();
			foreach (input('lang.code') as $k => $lang) {
				if (isset(input('lang.code')[$k]) && input('lang.code')[$k] != "") {
					$langs[] = "('".p(input('lang.code')[$k])."','".p(input('lang.title')[$k])."','".p(input('lang.url')[$k])."')";
				}
			}
			
			$sql = "DELETE FROM lang;";
			$res = $this->db->query($sql);
			
			$sql = "INSERT INTO lang (code, title, home_url) VALUES ".implode(",", $langs).";";
			$res = $this->db->query($sql);
			
		}
		
		$lang_query = "SELECT code, title, home_url FROM lang ORDER BY code";
		$res = $this->db->queryResults($lang_query);
		
		$this->clearcache(array('lang'));
		
		foreach($res as $k => $row) {
			$this->cacheForm('lang', array(
				"custom.code[".$k."]" => $row["code"],
				"custom.title[".$k."]" => $row["title"],
				"custom.url[".$k."]" => $row["home_url"]
			));
		}
		
		// load page template
		$this->loadView('admin.forge.lang.tpl');
	}
}


class admin_forge_menu extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/menu') || q('admin/edit/menu/*')))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;
 		
		// save form on posted data
		if (q(1)=='edit') {
			
			// when editing
			
			$id = (int) q(3);
			
			$this->cacheForm('menu');
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('menu','item.id', $id);
		
		} else {
			$this->clearcache(array('menu'));

			// when creating or posting data
			$id = 'new';
			
			// page form initial values
			$this->cacheForm('menu', array(
				//main
				'item.id' => $id,
				'content.title' => '',
				'content.lang' => 'en',
				'tags.name[0]' => 'menu',
				
				// menus
				'fields.level[0]' => 'first-level',
				'fields.title[0]' => 'Home',
				'fields.opto[0]' => 'url',
				'fields.url[0]' => '/',
				'fields.page[0]' => '1',
				'fields.index[0]' => '0',
			));
			
		}
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('menu'));
	
			// go to edit page once page created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/menu/'.input('item.id'));
			}
		}

		// load pages option
		$pages_sql = "SELECT * FROM shiftsmith WHERE `key`='content.title' AND `namespace` NOT LIKE 'menu';";
		$res = $this->db->querykvp($pages_sql);
		$myarr = array();
		if ($res) {
			foreach ($res as $k => $ret) {
				foreach ($ret as $i => $output) {
					if ($i=='id') {
						$myarr['item.id['.$k.']'] = $output;
					} else {
						$myarr['item.title['.$k.']'] = $output;
					}
				}
			}
			foreach ($myarr as $key => $arr) {
				$this->addModel("pages", $key, $arr);
			}
		} else {
			$this->addModel("pages", "item.id[0]", "");
			$this->addModel("pages", "item.title[0]", "");
		}
		
		// load languages
		$lang_query = "SELECT code, title FROM lang ORDER BY code";
		$res = $this->db->queryResults($lang_query);
		foreach($res as $k => $row) {
			$this->addModel("lang", "custom.code[".$k."]", $row["code"]);
			$this->addModel("lang", "custom.title[".$k."]", $row["title"]);
		}
		
		// load page template
		$this->loadView('admin.forge.menu.tpl');
	}
}


class admin_forge_page extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/page') || q('admin/edit/page/*')))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.id') == '') {
			// on page land, clear cache
			$this->clearcache(array('page'));
		}
 		
		// when editing
		if (q(1)=='edit') {
			// load values into form
			$this->cacheForm('page', array(
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));

			$id = (int) q(3);
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('page','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// page form initial values
			$this->cacheForm('page', array(
				'item.id' => $id,
				'content.title' => '',
				'content.lang' => 'en',
				'trigger.date' => '',
				'trigger.url' => '',
				'trigger.private' => 'N',
				'content.body' => '',
				'tags.name[0]' => 'page',
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));
		}
		
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('page'));
			
			// set prompt saved form success
			$this->setModel('prompt', 'message', 'Page saved to database.');
		
			// go to edit page once page created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/page/'.input('item.id'));
			}
		}
		
		// load languages
		$lang_query = "SELECT code, title FROM lang ORDER BY code";
		$res = $this->db->queryResults($lang_query);
		$this->clearcache(array('lang'));
		foreach($res as $k => $row) {
			$this->cacheForm('lang', array(
				"custom.code[".$k."]" => $row["code"],
				"custom.title[".$k."]" => $row["title"]
			));
		}
		
		// load page template
		$this->loadView('admin.forge.page.tpl');
	}
}

class admin_forge_csv extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && q('admin/create/import-csv'))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.posted') == '') {
			// on page land, clear cache
			$this->clearcache(array('page'));
		}
 		
		$this->cacheForm('csv', array(
			'params.rowdelimiter' => '\n|\r\n',
			'params.coldelimiter' => ';',
			'params.arraydelimiter' => ',',
			'params.datamode' => 'update'
		));

		$param_del_row = $this->getModel('csv', 'params.rowdelimiter');
		$param_del_row = "/$param_del_row/";

		$param_del_col = $this->getModel('csv', 'params.coldelimiter');
		$param_del_col = "/$param_del_col/";

		$param_del_arr = $this->getModel('csv', 'params.arraydelimiter');
		$param_del_arr = "/$param_del_arr/";

		$param_data_mode = $this->getModel('csv', 'params.datamode');

		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if ((input('item.posted') == 'Y') && ($_FILES['csvfile'])) {
			
			// load CSV
			$data = @file_get_contents($_FILES['csvfile']['tmp_name']);
		
			// Get header row
			$rows = preg_split($param_del_row, $data);
			$headers = preg_split($param_del_col, $rows[0]);
			$header_with_id = -1;
			
			foreach ($headers as $index => $head) {
				if (trim($head)=='id') {
					$header_with_id = $index;
				}
			}
			
			// Parse CSV
			$sql_query = 'INSERT INTO shiftsmith (`id`, `namespace`, `key`, `value`) VALUES ';
			$sql_values_stack = array();
			$sql_ids_to_delete = array();
			$sql_ids_to_skip = array();
			$ini_row = $this->db->getShift(); // get autoincrement number
			array_shift($rows); // remove header row
			
			foreach ($rows as $key => $row) {
				$id = $key + $ini_row + 1;
				$cols = preg_split($param_del_col, $row);
				if ($param_data_mode != 'append') {
					if ($header_with_id > -1) {
						$id = (int) $cols[$header_with_id];
						if ($param_data_mode == 'skip') {
							$sql_ids_to_skip[] = $id;
						}
					}
				}
				if ($param_data_mode == 'update') {
					$sql_ids_to_delete[] = (int) $id;
				}
				foreach ($cols as $k => $col) {
					$arr = preg_split($param_del_arr, $col);
					if (count($arr) >= 2) {
						foreach ($arr as $kk => $arr) {
							$id = (int) $id;
							$sql_values_stack[]= "(".$id.", 'csv', '".$headers[$k]."[".$kk."]', '".$arr."')";
						}
					} else {
						$id = (int) $id;
						$sql_values_stack[]= "(".$id.", 'csv', '".$headers[$k]."', '".$col."')";
					}
					
				}
			}
			
			if (count($sql_ids_to_delete) > 0) {
				$del_query = "DELETE FROM shiftsmith WHERE `id` IN (".implode(',', $sql_ids_to_delete).");";
				$this->db->query($del_query);
			}
			
			$sql_query .= implode(',', $sql_values_stack)."";
			if ((count($sql_ids_to_skip) > 0) && ($param_data_mode == 'skip')) {
				$sql_query .= " WHERE id NOT IN (".implode(',', $sql_ids_to_skip).")";
			}
			$sql_query .= ";";
			$this->db->query($sql_query);
			
			// Reload page with success message
			$this->setModel('prompt', 'message', 'Successfully imported CSV file');
		}
		
		// load page template
		$this->loadView('admin.forge.csv.tpl');
	}
}
class admin_forge_post extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/post') || q('admin/edit/post/*')))
			return 1;
		else return false;
	}

	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.id') == '' || input('item.id') == 'new') {
			// on post land, clear cache
			$this->clearcache(array('post'));
		}
 		
		// when editing
		if (q(1)=='edit') {
			// load values into form
			$this->cacheForm('post', array(
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));

			$id = (int) q(3);
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('post','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// post form initial values
			$this->cacheForm('post', array(
				'item.id' => $id,
				'content.title' => '',
				'trigger.date' => '',
				'trigger.url' => '',
				'trigger.private' => 'N',
				'content.body' => '',
				'tags.name[0]' => 'post',
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));
		}
		
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('post'));
			
			// set prompt saved form success
			$this->setModel('prompt', 'message', 'Post saved to database.');
		
			// go to edit post once post created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/post/'.input('item.id'));
			}
		}
		
		// load post template
		$this->loadView('admin.forge.post.tpl');
	}
}

class admin_forge_block extends Controller {
	
	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/block') || q('admin/edit/block/*')))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.id') == '') {
			// on block land, clear cache
			$this->clearcache(array('block'));
		}
 		
		// when editing
		if (q(1)=='edit') {
			$this->cacheForm('block', array(
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));

			// load values into form
			$id = (int) q(3);
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('block','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// block form initial values
			$this->cacheForm('block', array(
				'item.id' => $id,
				'content.title' => '',
				'trigger.date' => '',
				'trigger.url' => '',
				'trigger.shortcode' => '',
				'trigger.private' => 'N',
				'content.body' => '',
				'tags.name[0]' => 'block',
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));
		}
		
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('block'));
			
			// set prompt saved form success
			$this->setModel('prompt', 'message', 'Block saved to database.');
		
			// go to edit page once page created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/block/'.input('item.id'));
			}
		}
		
		// load block template
		$this->loadView('admin.forge.block.tpl');
	}
}

class admin_forge_sale extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/sale') || q('admin/edit/sale/*')))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.id') == '') {
			// on sale land, clear cache
			$this->clearcache(array('sale'));
		}
 		
		// when editing
		if (q(1)=='edit') {
			$this->cacheForm('sale', array(
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));

			// load values into form
			$id = (int) q(3);
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('sale','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// sale form initial values
			$this->cacheForm('sale', array(
				'item.id' => $id,
				'content.title' => "",
				'trigger.url' => "",
				'content.body' => "",
				'tags.name[0]' => 'sale',
				'trigger.private' => 'N',
				'item.date' => '',
				'item.onsaleuntil' => '',
				'item.inventory' => '1',
				'item.price' => '0',
				'item.saleprice' => '0',
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => ''
			));
		}
		
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('sale'));
			
			// set prompt saved form success
			$this->setModel('prompt', 'message', 'Sale saved to database.');
		
			// go to edit page once page created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/sale/'.input('item.id'));
			}
		}
		
		// load sale template
		$this->loadView('admin.forge.sale.tpl');
	}
}

class admin_forge_form extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/create/form') || q('admin/edit/form/*')))
			return 1;
		else return false;
	}
	
	function execute() {
		$id = 0;

		// when not posting form
		if (input('item.id') == '') {
			// on form land, clear cache
			$this->clearcache(array('form'));
		}
 		
		// when editing
		if (q(1)=='edit') {
			$this->cacheForm('form', array(
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => '',
				'fields.head[0]' => '',
				'fields.head[1]' => '',
				'fields.ctype[0]' => '',
				'fields.ctype[1]' => '',
				'fields.value[0]' => '',
				'fields.value[1]' => ''
			));

			// load values into form
			$id = (int) q(3);
			
			$res = $this->db->querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('form','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// form form initial values
			$this->cacheForm('form', array(
				'item.id' => $id,
				'content.title' => "",
				'trigger.url' => "",
				'content.body' => "",
				'tags.name[0]' => 'form',
				'trigger.date' => '',
				'trigger.shortcode' => '',
				'trigger.private' => 'N',
				'item.date' => '',
				'fields.value[0]' => '',
				'custom.header[0]' => '',
				'custom.header[1]' => '',
				'custom.value[0]' => '',
				'custom.value[1]' => '',
				'fields.head[0]' => '',
				'fields.head[1]' => '',
				'fields.ctype[0]' => '',
				'fields.ctype[1]' => '',
				'fields.value[0]' => '',
				'fields.value[1]' => ''
			));
		}
		
		// set initial prompts
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		// if posting value
		if (input('item.id') != '') {
			// save current input data
			$this->saveForm(input('item.id'), array('form'));
			
			// set prompt saved form success
			$this->setModel('prompt', 'message', 'Form saved to database.');
		
			// go to edit page once page created.
			if (is_numeric(input('item.id'))) {
				redirect('/admin/edit/form/'.input('item.id'));
			}
		}
		
		// load form template
		$this->loadView('admin.forge.form.tpl');
	}
}

class admin_wizard_upload extends Controller {

	function validate() {
		if (($this->user->isAdmin()) && (q('admin/wizard/upload') || q('admin/upload/wizard')))
			return 1;
		else return false;
	}
	
	function execute() {
		$uploads_dir = 'webapp/files/upload';
		if (isset($_FILES) && isset($_FILES['file'])) {
			foreach ($_FILES["file"]["error"] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["file"]["tmp_name"][$key];
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["file"]["name"][$key]);
					move_uploaded_file($tmp_name, "$uploads_dir/$name");
					switch (end(explode(".", $name))) {
						case "csv":
							//redirect('admin/wizard/options/csv');
							break;
						case "sql":
							//redirect('admin/wizard/options/sql');
							break;
					}
				}
			}
		}
		//$this->loadView('admin.forge.tpl');
	}
}