<?php

$uin_code = md5($dbname.$dbserver); 

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
  
?>
	</head>
	<body>
		<div id="container">
			<div id="top"></div>
      <div id="header"><a href="."><img src="<?php echo $url_images; ?>title.png" title="Addressbook" alt="Addressbook" /></a></div>
			<div id="nav"></div>
			<div id="content">
        <form accept-charset="utf-8" name="LoginForm" method="post">
	         <label><?php echo ucfmsg("USER"); ?>:</label><input name="user" tabindex="0"/><br/>
	         <label><?php echo ucfmsg("PASS"); ?>:</label><input name="pass" type="password"/><br/>
	         <input type=submit value="<?php echo ucfmsg("LOGIN"); ?>"/>
        </form>
      </div>
<?php
	die;
}
?>