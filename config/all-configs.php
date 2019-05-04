<?php

	namespace Wizard\Build;

	class Config {

		// define if debugging or not
		public const DEBUG = true;

		// define theme
		public const ACTIVE_THEME = 'WizardHat';
		
		// define theme
		public const CRON_JOB_TOKEN = 'ddfc336faff4f45bb9beff4bea319364';
		
		static public $CMS_DB_HOST;
		static public $CMS_DB_USER;
		static public $CMS_DB_PASS;
		static public $CMS_DB_NAME;

		public function __construct() {

			include "cms-configs.php";

			self::$CMS_DB_HOST = $CMS_DB_HOST;
			self::$CMS_DB_USER = $CMS_DB_USER;
			self::$CMS_DB_PASS = $CMS_DB_PASS;
			self::$CMS_DB_NAME = $CMS_DB_NAME;
		}
	}
?>
