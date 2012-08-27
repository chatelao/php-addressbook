<?php

include"master_inc.php";

$lastname      = "";
$firstname     = "";
$phone         = "";
$password_hint = "";

// User unique ?
$username = strip_tags(substr($_POST['email'],0,32));
if(trim($username)!=='' || strlen(trim($username)) >= 4){
   //email unique?
   $sql    = "SELECT * FROM ".$usertable." WHERE username='$username'";
   $result = mysql_query($sql);
   $count  = mysql_num_rows($result);
   if($count>0){
      $username_already_in_use = 104;
   }
}else{
   $username_too_short = 104;
}

//email format check
$email_raw = $_REQUEST['email'];
if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([a-z0-9-]{2,3})+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $email_raw))
{ 
  $email = $email_raw;
}else{
  $bad_email = 104;
} 

if($require_email_unique) {
  $sql="SELECT * FROM ".$usertable." WHERE email='$email'";
  $result=mysql_query($sql);
  $count=mysql_num_rows($result);
  if($count>0){
  $email_already_in_use=104;
  }
}

//Secure Password Format Checks
$password = $_POST['password'];
if($require_secure_password) {
  $pw_clean = strip_tags(substr($password,0,32));
  if (preg_match("/[A-Z]+[a-z]+[0-9]/", $pw_clean, $matches)) {
  }else{
  $pw_insecure = 104;
  }
} else {
	$pw_clean = $password;
}

if($username_already_in_use==104 OR $email_already_in_use==104 OR $pw_insecure==104 OR $bad_email==104 OR $username_too_short==104){
header(
 "location:user_add_errors.php?pw_insecure=$pw_insecure&email_already_in_use=$email_already_in_use&username_already_in_use=$username_already_in_use&bad_email=$bad_email&username_too_short=$username_too_short"
."&email=$email&password=$password");
die();
}
//End Error Checks_________________________________________________________

//Encrypt Password
$encrypted_pw = md5($pw_clean);
$query = "INSERT INTO ".$usertable."
(domain_id, username, md5_pass, lastname, firstname, email, phone, password_hint) 
select max(domain_id)+1 domain_id
     , '".mysql_real_escape_string($username)."'      username     
     , '".mysql_real_escape_string($encrypted_pw)."'  md5_pass
     , '".mysql_real_escape_string($lastname)."'      lastname
     , '".mysql_real_escape_string($firstname)."'     firstname
     , '".mysql_real_escape_string($email)."'         email
     , '".mysql_real_escape_string($phone)."'         phone  
     , '".mysql_real_escape_string($password_hint)."' password_hint from ".$usertable.";";
     
// save the info to the database
$results = mysql_query( $query );
// print out the results
if( $results ) {
  //
  // Automatic login after registration
  //
	$ip_date  = $_SERVER['REMOTE_ADDR']."_".date('Y-m');
	$uin = md5($username.$encrypted_pw.$ip_date);
  setcookie("uin", $uin, 0, "/");
?>  
  <meta http-equiv="refresh" content="0;url=../index.php">
<?php
/*
	include "header.html";
  echo "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Your changes have been made sucessfully.
        <br><br><a href='/books'>Back to login</a></font>";
*/
}
else
{
die( "Trouble saving information to the database: " . mysql_error() );
}
//email unique?
$sql="SELECT * FROM ".$usertable."";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count==1){

$query = "UPDATE `users` SET `permissions`='5' WHERE `email`='$email'"; 
// save the info to the database
$results = mysql_query( $query );
// print out the results
if( $results )
{ echo( "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'><br><br>Since this is the first user in the database we have configured the account with administrative privileges. Subsequent changes to permission levels can be made in the database. Thank you.<br></font> " );
}
else
{
die( "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Trouble saving information to the database:</font> " . mysql_error() );
}

}
?>