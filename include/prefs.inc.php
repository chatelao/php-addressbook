<?php

$cookie_prefix = "phpaddr_";

$cookie_names[] = 'language';
$cookie_names[] = 'mailer';

//
// Write preference to cookie
//
foreach($cookie_names as $cookie_name) {
	if(isset($_POST[$cookie_name])) {
    setcookie($cookie_prefix.$cookie_name, $_POST[$cookie_name]);
  }
}

//
// Get preference
//
function getPref($key) {
	
	global $cookie_prefix, $_POST, $_COOKIE;
	
	if(isset($_POST[$key])) {
		return $_POST[$key];
	} elseif(isset($_COOKIE[$cookie_prefix.$key])) {
		return $_COOKIE[$cookie_prefix.$key];		
	}
}

?>