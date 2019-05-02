<?php
	namespace Wizard\Build;

	class Database {
		static private $dbtype;
		static private $dblink;
		static private $isConnected;
		static private $counted = 0;

		public function __construct() {
			$con = self::connect(CMS_DB_HOST, CMS_DB_USER, CMS_DB_PASS, CMS_DB_NAME);
			return $con;
		}

		static public function connect($host, $user, $password, $database, $dbtype='mysql') {
			
			self::$isConnected = false;

			try {
				self::$dbtype = $dbtype;

				if (self::$dbtype=='mysql') {
					self::$dblink = new \mysqli($host, $user, $password, $database);
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
				if (\Wizard\Build\Config::DEBUG) {
					self::$counted++;
					$myModel = new \Wizard\Build\Model("sql_".self::$counted, $query, "stats");
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

		static function write($row, $ns, $defs) {
			$secs = array();
			foreach ($row as $sec) {
				$secs[] = "'".mysqli_real_escape_string(self::$dblink, $sec)."'";
			}
			$sql = "INSERT INTO ".$ns."(".implode(",", $defs).") VALUES (".implode(",", $secs).");";

			self::query($sql);
		}
		static function setTable($namespace, $defs) {
			$sql = "CREATE TABLE ".$namespace." (";
			$sqlq = array();
			foreach($defs as $def) {
				$sqlq[] = $def." VARCHAR(255) NOT NULL";
			}
			$sql .= implode(",", $sqlq); 
			$sql .=	")";

			self::query($sql);
		}
	}
?>
