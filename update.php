<?php

/*

Params: install = zip file path, eg: "v0.1.1.zip"
		db_host = eg localhost
		db_user = eg root
		db_pass = eg 1234
		db = eg wwb

*/

// When Wizard.Build is already installed, skip installation
if (file_exists("core/core.php")) {
	echo "Wizard.Build core found. Installation Failed. Login to your admin panel to update or re-install Wizard.Build";
	die();
}

// provide install file (zip)
$zip_path = basename($_POST['install']);

$zip = new ZipArchive;
if ($zip->open($zip_path) === TRUE) {
	
	// unzip main app files
    $zip->extractTo('./');
    $zip->close();
	
} else {
    echo 'failed';
	die();
}


// Initialize database
$zip = new ZipArchive;
if ($zip->open("./webapp/files/private/init.sql.zip") === TRUE) {
	
	// unzip db files
    $zip->extractTo('./');
    $zip->close();
	
} else {
    echo 'failed';
	die();
}
// import init file from db
$link = mysqli_connect($_POST["db_host"], $_POST["db_user"], $_POST["db_pass"], $_POST["db"]);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    die();
}
$sqlSource = file_get_contents('./init.sql');
mysqli_multi_query($sql,$sqlSource);
mysqli_close($link);

//cleanup
unlink('./init.sql');

// write db access config if not existant
if (!file_exists("./config/config-cms.php")) {
	file_put_contents("./config/config-cms.php",
	"<?php\n
		define('CMS_DB_HOST', '".$_POST["db_host"]."');\n
		define('CMS_DB_USER', '".$_POST["db_user"]."');\n
		define('CMS_DB_PASS', '".$_POST["db_pass"]."');\n
		define('CMS_DB_NAME', '".$_POST["db"]."');\n
	?>");
}

?>