<?php

function hasRoleFromIP($iplist) {
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$is_white = array_key_exists($ip, $iplist);
	
	if($is_white) {
	  return $iplist[$ip];
	} else {
		return false;
	}
}

class User {
	
	private $name;
	private $config;
	
	function __construct($username, $config) {
	  $this->name = $username;
	  $this->config = $config;
	}
	
	function getConfig() {
		return $this->config;
	}	
	
	function hasRole($rolename) {
  
    $config = $this->config;
    
    if(   isset($this->config['role'])
       && $rolename == $this->config['role']) {
      return true;
    }
    if(   isset($this->config['roles'])
       && in_array($rolename, $this->config['roles'])) {
      return true;
    }
    return false;
  }

	function getName() {
		return $this->name;
	}
}

class Login {

  static $uin;

  // Create a locally unique, monthly changing cookie value.
  static function getUIN($user, $pass) {
  
    return md5($user.$pass.$_SERVER['REMOTE_ADDR'].date('Y-m'));
    
  }
  
  static function getUser() {
  	
  	global $userlist;

  	foreach($userlist as $user => $config) {
  		if(   array_key_exists('pass', $config)
  		  &&  self::getUIN($user, $config['pass']) == self::$uin) {
  			return new User($user, $config);
  		}
  	}
  	return "";
  }
  
  static function isValidUIN() {
  	return !(self::getUser(self::$uin) == "");
  }
  
  public static function isUser() {
  	return isset($userlist);
  }
  
  public static function hasUserConfig($key) {
  	return self::isUser() && isset($userlist[self::getUser()][$key]);
  }
  
  public static function getUserConfig($key) {
  	if(self::isUser() && isset($userlist[self::getUser()][$key])) {
  		return $userlist[self::getUser()][$key];
  	} else {
  		return "";
  	}
  }

  public static function checkRoles($roles = array()) {
  	
  	global $userlist, $_POST, $_COOKIE, $_SERVER;
  	
    $user       = (isset($_POST['user'])  ? $_POST['user'] : (isset($_GET['user'])  ? $_GET['user'] : ""));
    $pass       = (isset($_POST['pass'])  ? $_POST['pass'] : (isset($_GET['pass'])  ? $_GET['pass'] : ""));
    self::$uin  = (isset($_COOKIE['uin']) ? $_COOKIE['uin']: "");
    
    if(!isset($userlist)) { 
    	
    	// No users with passwords defined:, ok
    	return true;
    	
    } elseif(self::isValidUIN() && !isset($_POST['logout'])) { 
    	
    	// Session: ok
    	return true;
    	
    } elseif(isset($userlist[$user]) && $userlist[$user]['pass'] == $pass) { 
    
      // User/Passwort: ok
      self::$uin  = self::getUIN($user, $pass);
      setcookie("uin", self::$uin, 0);
    	return true;
    
    } else { 
    	
  	  // Reset the cookie
  	  if(isset($_POST['logout'])) {
          setcookie("uin", "logged-out", 0);
   	  }
      	
      return false;
    }
  }
}
?>