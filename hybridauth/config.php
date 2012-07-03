<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | https://github.com/hybridauth/hybridauth
*  (c) 2009-2011 HybridAuth authors | hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------


	//
	// Include site specific configuration from "cfg.sso.php
	//
  include(dirname(__FILE__).DIRECTORY_SEPARATOR.".."
                           .DIRECTORY_SEPARATOR."config"
                           .DIRECTORY_SEPARATOR."cfg.sso.php");

//  $result["base_url"]   = $sso_protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$sso_endpoint;  
  $result["base_url"]   = 'https://swiss-addressbook/auth';
  $result["debug_mode"] = $sso_log_enabled;
  $result["debug_file"] = $sso_log_file;

  $result["providers"]["Google"]["enabled"]           = isset($sso_google_id) && $sso_google_id != "";
  $result["providers"]["Google"]["keys"]["id"]        = $sso_google_id;
  $result["providers"]["Google"]["keys"]["secret"]    = $sso_google_secret;
  
  $result["providers"]["Facebook"]["enabled"]         = isset($sso_facebook_id) && $sso_facebook_id != "";
  $result["providers"]["Facebook"]["keys"]["id"]      = $sso_facebook_id;
  $result["providers"]["Facebook"]["keys"]["secret"]  = $sso_facebook_secret;

  $result["providers"]["Live"]["enabled"]             = isset($sso_hotmail_id) && $sso_hotmail_id != "";
  $result["providers"]["Live"]["keys"]["id"]          = $sso_hotmail_id;
  $result["providers"]["Live"]["keys"]["secret"]      = $sso_hotmail_secret;


  // ****************************************************************
  // DEFAULT VALUES
  $result = array();
  $result["providers"] = array ( 
			"Facebook" => array ( 
				"scope"   => "email", 
  			"display" => "" 
			),
			"Google" => array ( 
				"scope"   => ""
			)
	  );

	return $result;
	
?>