<?php

include"master_inc.php";

$username_from_cookie = isset($_COOKIE[$cookiename]) ? $_COOKIE[$cookiename] : "";

$sql="SELECT * FROM users WHERE username=?";

$result = $db_access->execute($sql, array($username_from_cookie));

// Mysql_num_row is counting table rows

$count = $db_access->numRows($result);

//echo "count: $count<br>";

// If result matches $myusername and $mypassword, table row must be 1 row

if($count==0){
    echo "Sorry but we don't have that email in our system.  <a href='email_password.php'>Please try again.</a>  Thank you!";
}

?>
