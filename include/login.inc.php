<?php

interface AuthUser {
	
	function getDomain();
	function getName();
	
}

interface AuthLogin {
	
  public function hasLogout();
  public function hasValidUserPass();
  public function getUser();
  public function hasRoles($roles = array());
}

function hasRole($login, $role) {
	return $login->hasRoles(array($role));
}


//
//---------------- Implementations ---------------
//
class AuthUserConfig implements AuthUser {

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

	function getDomain() {
    if(isset($this->config['domain'])) {
      return $this->config['domain'];
    } else {
      return 0; // the default domain
    }
	}
	function getName() {
		return $this->name;
	}

    function getGroup() {
        if(isset($this->config['group'])) {
            return $this->config['group'];
        } else {
            return ""; // no group
        }
    }
}

//
// Login implementations
//
class AuthLoginFactory {


	static function getBestLogin($required_roles = array()) {

    global $iplist, $blacklist, $userlist, $db, $usertable, $use_sso;

    if((!isset($login) || !$login->hasRoles()) && isset($userlist)) {
      $login = new AuthLoginUserList($userlist);
    }
    if((!isset($login) || !$login->hasRoles()) && isset($usertable)) {
      $login = new AuthLoginDb($db, $usertable);
    }
    if($use_sso && (!isset($login) || !$login->hasRoles()) && is_dir('hybridauth')
       && !(isset($_POST['logout']) && $_POST['logout'] == "yes")) {
      $login = new AuthHybrid($db, $usertable);
    }
		if(  (!isset($login) || !$login->hasRoles()) 
		   && isset($iplist) && !(isset($_POST['logout']) && $_POST['logout'] == "yes")) {
		  if(isset($blacklist)) {
        $login = new AuthLoginIP($iplist, $blacklist);
      } else {
        $login = new AuthLoginIP($iplist);
      }
    }
    if(!isset($iplist) && !isset($userlist)) {
      $login = new AuthLoginAlways();
    }

    return $login;
	}
}

abstract class AuthLoginImpl implements AuthLogin {
	
	protected $user_id;
	
	function __construct() {
	  $this->user_id = -1;
	}	

  public function hasValidUserPass() {
  	return $this->user_id != -1;
  }
}

class AuthLoginAlways extends AuthLoginImpl {

	function __construct() {
		parent::__construct();
	}
	
  function hasValidUserPass() {
  	return true;
  }

  public function hasRoles($roles = array()) {
  	return (count($roles) == 0);
  }

  public function getUser() {
  	return new AuthUserConfig("", array());
  }

  public function hasLogout() {
  	return false;
  }
}

class AuthLoginIP extends AuthLoginImpl {

  private $whitelist;
  private $blacklist;
  private $ip;

	function __construct($whitelist, $blacklist = array()) {

		parent::__construct();

	  $this->ip = $_SERVER['REMOTE_ADDR'];
		$this->whitelist = $whitelist;
		$this->blacklist = $blacklist;
	}

	function calcMin($sub_range) {

		$sub_range_elements = explode('-',$sub_range);
		if(count($sub_range_elements) == 2) {
			return $sub_range_elements[0];
		} elseif($sub_range == "*") {
			return 0;
		} else {
			return $sub_range;
	  }
	}

	function calcMax($sub_range) {

		$sub_range_elements = explode('-',$sub_range);
		if(count($sub_range_elements) == 2) {
			return $sub_range_elements[1];
		} elseif($sub_range == "*") {
			return 255;
		} else {
			return $sub_range;
	  }
	}

	function getIpValue() {

    $result = 0;
    $sub_ranges = explode(".", $this->ip);
    foreach($sub_ranges as $sub_range) {
    	 $result *= 256;
    	 $result += $sub_range;
    }
    return $result;
  }

  function isInIpRange($range) {

		$sub_ranges = explode(".", $range);
    $min = 0;
    $max = 0;
		foreach($sub_ranges as $sub_range) {
			$min = $min * 256;
			$min = $min + $this->calcMin($sub_range);
			$max = $max * 256;
			$max = $max + $this->calcMax($sub_range);
		}
	  return ($this->getIpValue() >= $min) && ($this->getIpValue() <= $max);
	}

  function isInIpRanges($ranges) {

		$result = false;
		foreach($ranges as $range => $config) {
			$result = $this->isInIpRange($range) || $result;
		}
		return $result;
	}

	function getConfigFromIpRange($ranges) {

		$result = false;
		foreach($ranges as $range => $config) {
			if($this->isInIpRange($range)) {
				return $config;
			}
		}
		return $result;
	}

  function hasValidUserPass() {
  	return $this->isInIpRanges($this->whitelist)
       && !$this->isInIpRanges($this->blacklist);
  }

  function hasRoles($roles = array()) {
	  if(count($roles) == 0) {
	  	return $this->hasValidUserPass();
	  }  	
	}

  public function getUser() {
  	return new AuthUserConfig($this->ip, $this->getConfigFromIpRange($this->whitelist));
  }

  public function hasLogout() {
  	return false;
  }
}

abstract class AuthLoginUserPass extends AuthLoginImpl {

  // Authentication stuff
  private $ip_date;
  private $uin;
  protected $username;
  protected $md5_pass;
  protected $user_cfg;
  
	function __construct() {

		parent::__construct();

    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      $this->ip_date  = $_SERVER['HTTP_USER_AGENT'].date('Y-m');
    } else {
    	// SimpleText does not send any default user agent
      $this->ip_date  = $_SERVER['REMOTE_ADDR'].date('Y-m');
    }
    $this->uin      = (isset($_COOKIE['uin']) ? $_COOKIE['uin'] : "");

	  //
	  // Handle the logout
	  //
		if(isset($_POST['logout'])) {
      setcookie("uin", "logged-out", 0);
      setcookie("PHPSESSID", "", 0);
      $this->uin = "logged-out";
    }    
	}
	
  function finishConstruct() {
    $this->uin = $this->genUIN($this->username, $this->md5_pass);
    setcookie("uin", $this->getUIN(), 0);
  }

  // Create a locally unique, monthly changing cookie value.
  function genUIN($username, $md5_pass) {
    return md5($username.$md5_pass.$this->ip_date);
  }
  function getUIN() {
  	return $this->uin;
  }

  function getM5P() {
  	return $this->md5_pass;
  }

  function getIpDate() {
  	return $this->ip_date;
  }

	public function getUserName() {
    $username   = (isset($_POST['user']) ? $_POST['user']
                : (isset($_GET['user'])  ? $_GET['user']
                : (isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER']
                : "")));

    return strtolower($username);
  }

  public function getPassWord() {

    $password   = (isset($_POST['pass'])  ? $_POST['pass']
                : (isset($_GET['pass'])   ? $_GET['pass']
                : (isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW']
                : "")));

    return $password;
  }

  public function hasLogout() {
  	return true;
  }

  public function hasRoles($roles = array()) {
  	
  	if($this->hasValidUserPass()) {
  		if(count($roles) == 0) {
    		return true;
    	} elseif(isset($this->user_cfg['role'])) {
    		return in_array($this->user_cfg['role'], $roles);
    	} elseif(isset($this->user_cfg['roles'])) {
    		return in_array($this->user_cfg['roles'], $roles);
    	} else {
    	  return false;
    	}
    } else {
    	return false;
    }
  }
  
  function getUser() {

  	if(isset($this->user_cfg)) {
      return new AuthUserConfig($this->username, $this->user_cfg);
    } else {
  	  return "";
  	}
  }  
}

class AuthLoginUserList extends AuthLoginUserPass {

  private $userlist;

	function __construct($userlist) {
		parent::__construct();

		$this->userlist = $userlist;

	  //
	  // Search with UIN
	  //
		if($this->getUIN() != "") {
  	  foreach($this->userlist as $username => $config) {
  	  	if(   array_key_exists('pass', $config)
  	  	  &&  $this->genUIN($username, md5($config['pass'])) == $this->getUIN()) {
  		    $this->user_id  = $username;
  	  	}
  	  }
    }
    
		//
		// Check the new user/pass
		//
 	  $username = $this->getUserName();
  	if(!$this->hasValidUserPass() && $username != "") {
      if(array_key_exists($username, $this->userlist)
         && $this->userlist[$username]['pass'] == $this->getPassWord()) {
 		    $this->user_id  = $username;
      }
    }
    
    if($this->user_id != -1) {
  	  $this->user_cfg = $this->userlist[$this->user_id];
  	  $this->username = $this->user_id;
  	  $this->md5_pass = md5($this->user_cfg['pass']);
  	}
  	
    $this->finishConstruct();
	}
}

class AuthLoginDb extends AuthLoginUserPass {

  // return md5($username.$md5_pass.$this->ip_date);

	function __construct($db_conn, $table) {
		
		parent::__construct();

		//
		// Check if UIN is valid in DB.
		//
		$cnt = 0;
	  if($this->getUIN() != "") {
	  	$uin = $this->getUIN();
			$sql = "select * from ".$table
			      ." where md5(concat(username,md5_pass,'".$this->getIpDate()."'))"
			          ." = '".mysql_real_escape_string($uin)."'";

      $result = mysql_query($sql);
      $rec = mysql_fetch_array($result);
      $cnt = mysql_numrows($result);
	  }
	  	 
	  //
		// Check if user is valid in DB.
		//
		if($cnt == 0 && $this->getUserName() != "") {
			$username       = $this->getUserName();
			$username_lower = strtolower($this->getUserName());
			$md5_pass       = md5($this->getPassWord());
			$md5_pass_lower = md5(strtolower($this->getPassWord()));

			$sql = "select user_id, domain_id, username, md5_pass from ".$table
			      ." where username in ('".mysql_real_escape_string($username)."','"
			                              .mysql_real_escape_string($username_lower)."')"
			        ." and md5_pass in ('".$md5_pass."','".$md5_pass_lower."');";

      $result = mysql_query($sql);
      $rec = mysql_fetch_array($result);
      $cnt = mysql_numrows($result);      
    }
	  
    if($cnt == 1) {
		  $this->user_id  = $rec['user_id'];
		  $this->username = $rec['username'];
		  $this->md5_pass = $rec['md5_pass'];
		  $this->user_cfg = array('domain' => $rec['domain_id']);
    }
    
    $this->finishConstruct();
	}
}

class AuthHybrid extends AuthLoginDb {

  // return md5($username.$md5_pass.$this->ip_date);

	function __construct($db_conn, $table) {
		
		parent::__construct($db_conn, $table);

	  //
		// Check if user is valid in DB.
		//
		$hybrid_types = array("facebook", "google", "yahoo", "live");
		$provider = $this->getUserName();
    
    // create an instance for Hybridauth with the configuration file path as parameter
 	  $hybridauth_config = "hybridauth".DIRECTORY_SEPARATOR."config.php";
 	  require_once( "hybridauth".DIRECTORY_SEPARATOR."Hybrid".DIRECTORY_SEPARATOR."Auth.php" );

		$hybridauth = new Hybrid_Auth( $hybridauth_config ); 	  
		$loaded_providers = Hybrid_Auth::getConnectedProviders();
		
		if($provider == "" && count($loaded_providers) > 0) {
      $provider = strtolower($loaded_providers[0]);
    } 	    
			
		if($provider != "" && in_array($provider, $hybrid_types)) {
      
		  try{
		  	
		  // try to authenticate the selected $provider
		  	$adapter = $hybridauth->authenticate( $provider );
      
		  // grab the user profile
		  	$user_profile = $adapter->getUserProfile();
		  	
		  	// a) Does user with "xxx" = identifier exist?
		  	//   -> Yes, then login as user			   
      
		  	// b) Does email of user exist?
		  	//   -> No, then create new user
      
		  	// c) Does email of user exist?
		  	//   -> Yes, ask for regular login. Preset email = login
		  	
		  	$provider_uid  = $user_profile->identifier;
		  	$email         = $user_profile->email;

        //
        // Check if user is valid in DB.
        //
           $sql = "select user_id, domain_id, username, md5_pass from ".$table
                ." where sso_".strtolower($provider)."_uid = '".$provider_uid."';";
           
           $result = mysql_query($sql);
           $rec = mysql_fetch_array($result);
           $cnt = mysql_numrows($result);      

        if($cnt == 1) {
    		  $this->user_id  = $rec['user_id'];
    		  $this->username = $rec['username'];
    		  $this->md5_pass = $rec['md5_pass'];
    		  $this->user_cfg = array('domain' => $rec['domain_id']);
        }    

		} catch( Exception $e ){
		  	// Display the recived error
		  	switch( $e->getCode() ){ 
		  		case 0 : $error = "Unspecified error."; break;
		  		case 1 : $error = "Hybriauth configuration error."; break;
		  		case 2 : $error = "Provider not properly configured."; break;
		  		case 3 : $error = "Unknown or disabled provider."; break;
		  		case 4 : $error = "Missing provider application credentials."; break;
		  		case 5 : $error = "Authentification failed. The user has canceled the authentication or the provider refused the connection."; break;
		  		case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
		  			     $adapter->logout(); 
		  			     break;
		  		case 7 : $error = "User not connected to the provider."; 
		  			     $adapter->logout(); 
		  			     break;
		  	}
		  	echo $error; 
		}
    }

    $this->finishConstruct();
	}
}
?>