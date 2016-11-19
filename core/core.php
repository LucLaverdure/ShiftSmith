<?php
	global $main_path;

	session_start();
	srand();

	define('IN_DREAMFORGERY', true);
	define("PATH", $main_path);

	// Includes
	include "config/config.php";
	if (file_exists('config/config-cms.php')) include "config/config-cms.php"; // include CMS configuration when installed
	include "phpQuery/phpQuery-onefile.php"; // third party
	include "core-prefunctions.php";
	include "core-db.php";
	include "core-mvc.php";
	include "core-process.php";
?>