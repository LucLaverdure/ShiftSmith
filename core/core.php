<?php
	global $main_path;

	session_start();
	srand();

	define('IN_SHIFTSMITH', true);
	define("PATH", $main_path);

	// Includes
	
	//configs
	if (file_exists($main_path."config/config-theme.php"))
		include $main_path."config/config-theme.php"; // include CMS configuration when installed
	include $main_path."config/config.php";
	if (file_exists($main_path."config/config-cms.php"))
		include $main_path."config/config-cms.php"; // include CMS configuration when installed
	
	// current theme shortcut
	include $main_path."core/core-theme.php";
	
	// mvc
	include $main_path."core/core-prefunctions.php";
	include $main_path."core/core-db.php";
	include $main_path."core/core-user.php";
	include $main_path."core/core-mvc.php";
	include $main_path."core/core-process.php";

?>