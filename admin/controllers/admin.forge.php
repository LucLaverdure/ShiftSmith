<?php

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
			
			$res = $this->db::querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
			$this->loadkvp($res);

			$this->addModel('page','item.id', $id);
		
		} else {
			// when creating
			$id = 'new';
			
			// page form initial values
			$this->cacheForm('page', array(
				'item.id' => $id,
				'content.title' => '',
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
		
		// load page template
		$this->loadView('admin.forge.page.tpl');
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
			
			$res = $this->db::querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
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
			
			$res = $this->db::querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
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
			
			$res = $this->db::querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
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
			
			$res = $this->db::querykvp("SELECT id, namespace, `key`, value FROM shiftsmith WHERE id=".$id.";");
			
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
				}
			}
		}
		$this->loadView('admin.forge.tpl');
	}
}