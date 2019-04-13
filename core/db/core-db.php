<?php
	namespace Wizard\Build;

	class Database {
		static private $dbtype;
		static private $dblink;
		static private $isConnected;
		static private $counted = 0;
		static public function connect($host=Config::CMS_DB_HOST, $user=Config::CMS_DB_USER, $password=Config::CMS_DB_PASS, $database=Config::CMS_DB_NAME, $dbtype='mysql') {
			
			self::$isConnected = false;
			
			try {
				self::$dbtype = $dbtype;

				if (self::$dbtype=='mysql') {
					self::$dblink = @new \mysqli($host, $user, $password, $database);
					if (!isset(self::$dblink->connect_error)) self::$isConnected = true;
				}

				return self::$dblink;
			
			} catch (Exception $e) {
				
				return false;
				
			}
			return self::$dblink;
		}

		static public function isConnected() {
			return self::$isConnected;
		}

		// query(SQL: ? for parameters, "idsb" (int, double, string, blob), arg1, arg2);
		static function query() {
			try {
				// init vars
				$values = array();
				$args = func_get_args();
				$query = array_shift($args);
				$stmt =  self::$dblink->stmt_init();

				// log sql query when in debug mode
				if (Wizard\Build\Config::DEBUG) {
					self::$counted++;
					$myModel = new \Wizard\Build\Model("sql_".self::$counted, $query, null, null, "stats");
				}

				// ex: INSERT INTO CountryLanguage VALUES (?, ?);
				if ($stmt->prepare($query)) {
					if (count($args) > 0) {
						$params_config = array_shift($args);

						// secure parameters into SQL query statement with unpacking parameters(...)
						$stmt->bind_param($params_config, ...$args);
					}
				}

				// execute SQL query
				@$stmt->execute();
				$ret = array();
				$results = @$stmt->get_result();
				while (($results != null) && ($row = $results->fetch_array(MYSQLI_BOTH))) {
					$ret[] = $row;
				}
				return $ret;
			} catch (Exception $e) {
				return false;
			}
		}

	}

	$con = Database::connect();
	if (!Database::isConnected()) die("Database connection failed");
?>
