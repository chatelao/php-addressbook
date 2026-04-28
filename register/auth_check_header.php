<?php

include_once "master_inc.php";

$username_from_cookie = isset($_COOKIE[$cookiename]) ? $_COOKIE[$cookiename] : ""; //retrieve contents of cookie

if($permission_level == '') {
  $sql = "SELECT * FROM users WHERE username = ?";
  $params = [$username_from_cookie];
} else {
  $threshold = $permission_level - 1;
  $sql = "SELECT * FROM users WHERE username = ? AND permissions > ?";
  $params = [$username_from_cookie, $threshold];
}

$result = $db_access->execute($sql, $params);

// Mysql_num_row is counting table rows
$count = $db_access->numRows($result);

// If result matches $myusername and $mypassword, table row must be 1 row
if($count == 0) {
  header("location:login.php");
  exit();
}

// now you can display the results returned
if ($row = $db_access->fetchArray($result)) {
  $permissions = $row["permissions"];
}

$username = $username_from_cookie;

?>