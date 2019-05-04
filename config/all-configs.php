<?php

	namespace Wizard\Build;

	class Config {

		// define if debugging or not
		public const DEBUG = true;

		// define theme
		public const ACTIVE_THEME = 'WizardHat';
		
		// define theme
		public const CRON_JOB_TOKEN = '';
		
		public function __construct() {

			if (file_exists("cms-configs.php")) include "cms-configs.php";

			if (!defined("CMS_DB_HOST")) define("CMS_DB_HOST", "");
			if (!defined("CMS_DB_USER")) define("CMS_DB_USER", "");
			if (!defined("CMS_DB_PASS")) define("CMS_DB_PASS", "");
			if (!defined("CMS_DB_NAME")) define("CMS_DB_NAME", "");

		}
	}
?>
