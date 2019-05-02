<?php
	/* This file contains shortcuts to functions and classes within namespaces */

	// query access
	function a($access_required) {
		return Wizard\Build\Tools::access($access_required);
	}
	function access($access_required) {
		return Wizard\Build\Tools::access($access_required);
	}
	
	
	// query url
	function q($argNumber_or_inPathString) {
		return Wizard\Build\Tools::queryURL($argNumber_or_inPathString);
	}
	function route($argNumber_or_inPathString) {
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
	function Model($key="var", $val="", $space="general", $type="s") {
		return new \Wizard\Build\Model($key, $val, $space, $type);
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

	function Posted($arg) {
		return \Wizard\Build\Tools::Posted($arg);
	}
?>
