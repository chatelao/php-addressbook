<?php

include "../config/config.php";

//**NOTE: No space can exist before <?PHP above or it will mess up the headers***

//**REQUIRED SETUP OPTIONS...SET VALUES 1-5 TO BEGIN USING BASICLOGIN BY CHANGING VALUES IN QUOTES.  WE ADVISE AGAINST CHANGING THE VARIABLE NAMES

//**STEP 1: What is the name of your site? I.E. basiclogin.com
$sitename     = $_SERVER['SERVER_NAME'];

//**STEP 2: What is the site domain for emails?  No http://www.  Just something.com
// $email_domain = $_SERVER['SERVER_NAME'];

//**STEP 3: What is the full path to the folder where the login script is located? I.E. https://www.yoursite.com/login_app
if($_SERVER['HTTPS']) {
  $domain = "https://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
} else {
  $domain = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
}

//**STEP 4: SET DATABASE CONNECTION VARIABLES:
  $db_host       = $dbserver;
  $db            = $dbname;
  $db_username   = $dbuser;
  $db_password   = $dbpass;
  $usertable     = $table_prefix.$usertable;

//**OPTIONS___________________________________________________________________________________________________________________________

//**OPTION: Where does a successful login redirect to?  Default is a router page that redirects according to permissions rules...but can be anywhere
$successful_login_url = "router.php";

//**OPTION: Where should the Router send users with various permission levels?
$level_5_url = "admin_index.php";
$level_4_url = "admin_index.php";
$level_3_url = "admin_index.php";
$level_2_url = "admin_index.php";
$level_1_url = "sample_page.php";

//**OPTION: Where does an unsuccessful login rediredt to?
$failed_login = "login_failed.php";

//**OPTION: What is the cookie name...can be anything...no whitespaces or special characters
$cookiename = "BasicLogin";

//**OPTION: Forgot Password Email Parameters:
$from_email        = "reminder@$email_domain";
$reply_to_email    = "reminder@$email_domain";
$return_path_email = "bounce@$email_domain";

//**OPTION: What is the subject of the email that you send to someone who forgot their password?
$forgot_password_email_subject = "Your $sitename password";

//**NO NEED TO CHANGE THIS
$email_4_pw_email = trim($_REQUEST['email']);

if($email_4_pw_email !==''){

   // connect to the server
   mysql_connect( $db_host, $db_username, $db_password )
      or die( "Error! Could not connect to database: " . mysql_error() );
   
   // select the database
   mysql_select_db( $db )
      or die( "Error! Could not select the database: " . mysql_error() );

//The following Query Gets password from database for email if called for 

$query = "SELECT * FROM ".$usertable." WHERE email = '".mysql_real_escape_string(trim($email_4_pw_email))."'"; 

$numresults = mysql_query($query);
$numrows    = mysql_num_rows($numresults); 

// get results
$result = mysql_query($query) or die("Couldn't execute query");

// now you can display the results returned
while ($row= mysql_fetch_array($result)) {

$email         = $row["email"];
$password      = $row["password"];
$password_hint = $row["password_hint"];

//Debug: echo "<br><br>Password:$password<br><br>";

if($password_hint !== '') {

//**OPTION: YOU CAN EDIT THE COPY IN THESE EMAILS IF YOU WANT.  THIS ONE IS FOR PEOPLE WHO HAVE A PASSWORD HINT

$restore_link = "$domain//reset_password.php?email=$email&password=$password";

$forgot_password_email = "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>This is the password manager at <b>$sitename</b>. We do not store passwords...only encrypted data. <br><br>Here is a password hint that you provided when you set up your account: $password_hint<br><br>If that helps, then you can <a href='$domain/login_app.php'>try again</a> without resetting your password<br><br>

<br>If you still can't remember then please <a href='".$restore_link."'>Click Here</a> to reset your password.  Clicking this link will assign an encrypted, temporary password for added security.  The process can easily be repeated if you experience difficutlties.<br><br> Best Regards - The Database</font>";
}
else
{

//**OPTION:  THIS ONE IS FOR PEOPLE WHO DON'T HAVE A PASSWORD HINT

$forgot_password_email = "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>This is the password manager at <b>$sitename</b>. We do not store passwords...only encrypted data.<br>
<br>Please <a href='$domain/reset_password.php?email=$email&password=$password'>Click Here</a> to reset your password.  Clicking this link will assign an encrypted, temporary password for added security.  The process can easily be repeated if you experience difficutlties.<br><br> Best Regards - The Database</font>";
}

}}

//**OPTION: THAT'S ALL FOR NOW.  MORE OPTIONS MAY BE ADDED LATER.  WE'LL LET YOU KNOW.  OTHERWISE, FEEL FREE TO ADD YOUR OWN!
?>