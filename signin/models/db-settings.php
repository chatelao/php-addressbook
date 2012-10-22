<?php
/*
UserCake Version: 2.0.1
http://usercake.com
*/

include(dirname(__FILE__).DIRECTORY_SEPARATOR.".."
                         .DIRECTORY_SEPARATOR.".."
                         .DIRECTORY_SEPARATOR."config"
                         .DIRECTORY_SEPARATOR."cfg.db.php");

// Database connection
$db_host         = $dbserver; // Host address (most likely localhost)
$db_name         = $dbname;   // Name of Database
$db_user         = $dbuser;   // Name of database user
$db_pass         = $dbpass;   // Password for database user

// Database table mapping
$db_table_prefix = $table_prefix;

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>