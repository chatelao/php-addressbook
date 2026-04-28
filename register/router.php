<?php

include"master_inc.php";

$username_from_cookie = isset($_COOKIE[$cookiename]) ? $_COOKIE[$cookiename] : ""; //retrieve contents of cookie

//Query to get permissions

$sql = "SELECT * FROM users WHERE `username` = ?";

$result = $db_access->execute($sql, array($username_from_cookie));

// now you can display the results returned
while ($row = $db_access->fetchArray($result)) {

  $permissions = $row["permissions"];

  //Set Rules for where various permissions go after login

  if($permissions==5)
  {
    header("location:$level_5_url");
    exit();
  }
  if($permissions==4)
  {
    header("location:$level_4_url");
    exit();
  }
  if($permissions==3)
  {
    header("location:$level_3_url");
    exit();
  }
  if($permissions==2)
  {
    header("location:$level_2_url");
    exit();
  }

  if($permissions==1)
  {
    header("location:$level_1_url");
    exit();
  }
}
?>
