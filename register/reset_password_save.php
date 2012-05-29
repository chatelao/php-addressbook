<?
include"master_inc.php";

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$password_confirm=$_REQUEST['password_confirm'];
$password_hint = $_REQUEST['password_hint'];
$email=$_REQUEST['email'];

if($password==$password_confirm){


$pw = strip_tags(substr($_POST['password'],0,32));
	
$cleanpw = md5($pw);

//Debug: echo"New User Defined PW: $cleanpw<br>email = $email | username = $username<br>";

$query = "UPDATE `users` SET `password`='$cleanpw', `password_hint`='$password_hint' WHERE `email`='$email'"; 

// save the info to the database
$results = mysql_query( $query );

// print out the results
if( $results )

{ echo( "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Your changes have been made sucessfully.<br><br><a href='login.php'>Back to Login</a></font>  " );
}
else
{
die( "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Trouble saving information to the database:</font> " . mysql_error() );
}

}
else
{
echo"<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Your new passwords do not match.  <a href='reset_password.php?email=$email'>Please try again</a>";
}

?>
