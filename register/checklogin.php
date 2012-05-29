<?php

include"login_config.php";

//Connection String Variables_________________________________________________

   // connect to the server
   mysql_connect( $db_host, $db_username, $db_password )
      or die( "Error! Could not connect to database: " . mysql_error() );
   
   // select the database
   mysql_select_db( $db )
      or die( "Error! Could not select the database: " . mysql_error() );

//IBM suggested scrub for URL request
$urlun = strip_tags(substr($_REQUEST['username'],0,32));
$urlpw = strip_tags(substr($_REQUEST['password'],0,32));

$cleanpw = md5($urlpw);

//echo"Cleanpw: $cleanpw<br>";

//$sql="SELECT * FROM agents WHERE username='$urlun' and password='$urlpw'";
$sql="SELECT * FROM users WHERE username='$urlun' and password='$cleanpw'";

$result=mysql_query($sql);

// Mysql_num_row is counting table rows

$count=mysql_num_rows($result);

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





