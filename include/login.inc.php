<?php

//
// Create a locally unique, daily changing cookie value.
//
$uin_code = md5($dbname.$dbserver.date('Y-m-d')); 

$user = (isset($_POST['user'])   ? $_POST['user'] : "");
$pass = (isset($_POST['pass'])   ? $_POST['pass'] : "");
$uin  = (isset($_COOKIE['uin']) ? $_COOKIE['uin'] : "");

if(!isset($userlist)) { 
	
	// No password defined
	
} elseif($uin == $uin_code) { 
	
	// Session ok
	
} elseif(isset($userlist[$user]) && $userlist[$user] == $pass) { 

  // User/Passwort ok

  setcookie("uin",$uin_code,0);

} else { 

  // Request Login
  include ("include/format.inc.php");

  if($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net") {
  	$set_user = "demo";
  	$set_pass = "1234";  	
  } else {
  	$set_user = "";
  	$set_pass = "";  	
  }
  
?>
	</head>
	<body>
		<div id="container">
			<div id="top"></div>
      <div id="header"><a href="."><img src="<?php echo $url_images; ?>title.png" title="Addressbook" alt="Addressbook" /></a></div>
			<div id="nav"></div>
			<div id="content">
        <form accept-charset="utf-8" name="LoginForm" method="post">
	         <label><?php echo ucfmsg("USER");     ?>:</label><input name="user" value="<?php echo $set_user; ?>" tabindex="0"/><br/>
	         <label><?php echo ucfmsg("PASSWORD"); ?>:</label><input name="pass" value="<?php echo $set_pass; ?>" type="password"/><br/>
	         <input type=submit value="<?php echo ucfmsg("LOGIN"); ?>"/>
        </form>
      </div>
	die;
}
?>