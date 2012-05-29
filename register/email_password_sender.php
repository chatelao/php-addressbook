<?

include "master_inc.php";

$email  = $_REQUEST['email'];
$sql    = "SELECT * FROM ".$usertable." WHERE email='".mysql_real_escape_string(trim($email))."'";
$result = mysql_query($sql);

// Mysql_num_row is counting table rows
$count  = mysql_num_rows($result);

// If result matches $myusername and $mypassword, table row must be 1 row
if($count == 0){

  die("<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Sorry but we don't have that email in our system.  <a href='email_password.php'>Please try again.</a>  Thank you!</font>");

}else{
	
  //comes from config which pulls from /inc
  $email_body = $forgot_password_email;
}
		
$from        = $from_email;
$reply_to    = $reply_to_email;
$return_path = $return_path_email;

$to = $email;

$subject = $forgot_password_email_subject;

//***attaches view tracker to link tracked code*** - CCC
$mailbody= "$email_body";

//____________________________Begin Multipart Mail Sender
//add From: header 
$headers = "From:$from\nReply-to:$reply_to\nReturn-path:$return_path\nJobID:$date\n"; 

//specify MIME version 1.0 
$headers .= "MIME-Version: 1.0\n"; 

//unique boundary 
$boundary = uniqid("HTMLDEMO8656856"); 

//tell e-mail client this e-mail contains//alternate versions 
$headers.="X-Priority: 3\n";
$headers.="Content-Type: multipart/alternative; boundary=\"".$boundary."\"\n";
$headers.="Content-Transfer-Encoding: 7bit\n";

//message to people with clients who don't 
//understand MIME 
$headers .= "This is a MIME encoded message.\n\n"; 

//plain text version of message 
$headers .= "--$boundary\n" . 
   "Content-Type: text/plain; charset=ISO-8859-1\r\n" . 
   "Content-Transfer-Encoding: base64\n\n"; 
$headers .= chunk_split(base64_encode("$mailbody")); 

//HTML version of message 
$headers .= "--$boundary\n" . 
   "Content-Type: text/html; charset=ISO-8859-1\n" . 
   "Content-Transfer-Encoding: base64\n\n"; 
$headers .= chunk_split(base64_encode("$mailbody")); 

//send message

If (mail("$to", "$subject", "", $headers))
{
echo"<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>An account verification link has been sent to <b><a href='mailto:$email'>$email</a></b>. This link will allow you to reset your password<br><br> Emails may take up to 10 minutes to arrive.  Check your spam folder also and whitelist this site if you find our message there.  Thanks!<br<br>
<a href='login.php'>Back to login</a></font>";
}
?>
