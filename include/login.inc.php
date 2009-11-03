<?php
/***************************************************
 *
 *
 *
 *
 *
 *
 ***************************************************/

function checkRoles($role = array()) {
	
	global $userlist, $_POST, $_COOKIE, $_SERVER;
	
	// Check if user is logged in, else show login-dialog
	
  //
  // Create a locally unique, monthly changing cookie value.
  //
  $uin_code = md5($dbname.$dbserver.$_SERVER['REMOTE_ADDR'].date('Y-m')); 
  
  $user = (isset($_POST['user'])   ? $_POST['user'] : "");
  $pass = (isset($_POST['pass'])   ? $_POST['pass'] : "");
  $uin  = (isset($_COOKIE['uin']) ? $_COOKIE['uin'] : "");
  
  if(!isset($userlist)) { 
  	
  	// No users with passwords defined:, ok
  	
  } elseif($uin == $uin_code && !isset($_POST['logout'])) { 
  	
  	// Session: ok
  	
  } elseif(isset($userlist[$user]) && $userlist[$user] == $pass) { 
  
    // User/Passwort: ok
  
    setcookie("uin",$uin_code,0);
  
  } else { 
  	
  	// Reset the cookie
  	if(isset($_POST['logout'])) {
      setcookie("uin", "logged-out", 0);
  	}
  	
    // Request Login
    include ("include/format.inc.php");
    
    // Load the template and exchange 
    $login_html_template = file_get_contents("login.html");
    $login_html_template = replace("USER",  ucfmsg("USER") , $login_html_template);
    $login_html_template = replace("PASS",  ucfmsg("PASS") , $login_html_template);
    $login_html_template = replace("LOGIN", ucfmsg("LOGIN"), $login_html_template);
    
  ?>

  <?php      
  	die;
  }
}
?>