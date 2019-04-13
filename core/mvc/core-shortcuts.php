<?php
	/* This file contains shortcuts to functions and classes within namespaces */

	// query access
	function a($access_required) {
		return Wizard\Build\Tools::access($access_required);
	}
	
	// query url
	function q($argNumber_or_inPathString) {
		return Wizard\Build\Tools::queryURL($argNumber_or_inPathString);
	}

	// query url
	function t($translate_string_id) {
		return Wizard\Build\Tools::translate($translate_string_id);
	}

	// View obj
	function View() {
		return new \Wizard\Build\View();
	}

	// Model obj
	//_construct($var, $val, $id=null, $parent_id=null, $namespace="general")
	function Model($var="var", $val="", $id=null, $parent_id=null, $namespace="general") {
		return new \Wizard\Build\Model($var, $val, $id, $parent_id, $namespace);
	}

	// Model Group obj
	function Group() {
		return new \Wizard\Build\Group();
	}
	function Table() {
		return new \Wizard\Build\Group();
	}
	function Matrix() {
		return new \Wizard\Build\Group();
	}

	// Database wrapper
	function DB() {
		return new Wizard\Build\Database();
	}
?>
