<?php

include"login_config.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR . "mysqli.database.php";

if(!isset($db_access)) {
  $db_access = new MysqliDatabase();
}

//Connection String Variables_________________________________________________

   // connect to the server
   $db_access->connect( $db_host, $db_username, $db_password )
      or die( "Error! Could not connect to database: " . $db_access->error() );

   // select the database
   $db_access->selectDb( $db )
      or die( "Error! Could not select the database: " . $db_access->error() );

//IBM suggested scrub for URL request
$urlun = strip_tags(substr($_REQUEST['username'],0,32));
$urlpw = strip_tags(substr($_REQUEST['password'],0,32));

$cleanpw = md5($urlpw);

//echo"Cleanpw: $cleanpw<br>";

//$sql="SELECT * FROM agents WHERE username='$urlun' and password='$urlpw'";
$sql="SELECT * FROM users WHERE username=? and password=?";

$result=$db_access->execute($sql, array($urlun, $cleanpw));

// Mysql_num_row is counting table rows

$count=$db_access->numRows($result);

// If result matches $myusername and $mypassword, table row must be 1 row

//echo"Count:$count<br>";

if($count==1){

// Register $myusername and redirect to file designated success file

$cookie_name ="$cookiename";

$cookie_value ="$urlun";

//set to 24 hours

$cookie_expire ="86400";

setcookie($cookie_name,$cookie_value,time() + (86400),"/", $cookie_domain);

header("location:$successful_login_url");

}else{

header("location:$failed_login");

}


?>
