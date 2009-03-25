<?php

//
// Handle the login:
// * Thanks to: http://www.tutorials.de/forum/php-tutorials/9684-php-mysql-login-system-mit-sessions.html

if(isset($_COOKIE[$cookie_prefix."session"])) {

  $login_cookie = $_COOKIE[$cookie_prefix."session"];
  
  $sql = " SELECT *
             FROM `addr_addressbook` 
            WHERE adddate(login, 20) >= now()
              AND md5(concat(firstname,lastname,'".$_SERVER['REMOTE_ADDR']."')) 
                   = '".$login_cookie."'";

  $result    = mysql_query($sql);
	$login_cnt = mysql_numrows($result);

  echo $login_cnt;
}

// Ignore Login
$login_cnt = 1;

if($login_cnt == 1) {

  $is_logged_in = true;
  
  //
  // $session_cookie = ...
  //
  // SELECT * FROM addr_addressbook where md5(concat(firstname,lastname,'195.186.54.177')) = 'fb4b0c89a9f962e2d746a7e12267f410'
  //
  // update addr_addressbook set login = now() where id = 1
  //
  // SELECT *
  //    FROM `addr_addressbook` 
  //   WHERE adddate(login, $passlimit) >= now()
  //     AND md5(concat(firstname,lastname,$_SERVER['REMOTE_ADDR'])) 
  //          = $login_cookie
  
} else {
	
  if(   $user == $admin_user
     && $pass == $admin_pwd) 
  {
  	
// --
// -- Revalidate the cookie
// --
//  UPDATE `addr_addressbook` 
//   WHERE (   email  = $user
//          OR email2 = $user )
//     AND md5($pass) = password;
//     SET login = now();

setcookie( $cookie_prefix."session"
         , md5 ($user.$pass.$_SERVER['REMOTE_ADDR'])
         );

// --
// -- Set a new password
// --
// UPDATE `addr_addressbook` 
//    SET `password` = md5('1234')
// WHERE (   email  = 'o.chatelain@ieee.org'
//        OR email2 = 'o.chatelain@ieee.org' ) 
  	
    $is_logged_in = true;
  } else {
    // sleep(1);
    $is_logged_in = false;
  }
}

/*
 $cookie = md5 (
    $username .
    $password .
    $_SERVER['REMOTE_ADDR']
 );
*/
?>
