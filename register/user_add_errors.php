<?php include "header.html"; ?>

<!--
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
-->      
<?php
  $username_already_in_use = $_REQUEST['username_already_in_use'];
	$email_already_in_use = $_REQUEST['email_already_in_use'];
	$pw_insecure = $_REQUEST['pw_insecure'];
	$bad_email = $_REQUEST['bad_email'];
	$username_too_short = $_REQUEST['username_too_short'];
	
		if($username_too_short==104) {
			echo "<font size='2' color='#ff0000' face='Verdana, Arial, Helvetica, sans-serif'>";
      echo "That username is too short.  Please make it more than 4 characters.<br><br>";
      echo "</font>";
    }
	
	if($username_already_in_use==104) {
		 echo "<font size='2' color='#ff0000' face='Verdana, Arial, Helvetica, sans-serif'>";
     echo "That username is already in use.  Please try again or log in to your existing account.<br><br>"; // </font>";
     echo "</font>";
  }

	if($email_already_in_use==104) {
		 echo "<font size='2' color='#ff0000' face='Verdana, Arial, Helvetica, sans-serif'>";
     echo "That email is already in use.  That probably means you have an existing account. Log in or <a href='email_password.php'>reset your password</a><br><br>";
     echo "</font>";
  }

	if($pw_insecure==104){
		 echo "<font size='2' color='#ff0000' face='Verdana, Arial, Helvetica, sans-serif'>";
     echo "Your Password is not formatted correctly.  Please choose a password that is between 4 and 20 characters and has at least 1 uppercase letter, one lower case letter and one number I.E. <i>Hello23</i>.<br><br>";
     echo "</font>";
  }
	
  if($bad_email==104){
   echo "<font size='2' color='#ff0000' face='Verdana, Arial, Helvetica, sans-serif'>";
   echo "Your email does not appear to be valid";
   echo "<br><br></font>";
  }


  ?></td>
    </tr>
  </table>
<?php include "user_add.form.php"; ?>
  <p>
    <?

?>
  </p>
  <p>&nbsp;</p>
</div>
