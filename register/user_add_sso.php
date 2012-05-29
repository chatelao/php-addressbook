<?php

 	 $hybridauth_config = /* dirname(__FILE__) . */ '../hybridauth/config.php';
 	 require_once( "../hybridauth/Hybrid/Auth.php" );

		try{
			
		// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybrid_Auth( $hybridauth_config );

		// try to authenticate the selected $provider
			$adapter = $hybridauth->authenticate( $username );

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
			$first_name    = $user_profile->firstName;
			$last_name     = $user_profile->lastName;
			$display_name  = $user_profile->displayName;
			$website_url   = $user_profile->webSiteURL;
			$profile_url   = $user_profile->profileURL;
			$password      = rand( ) ; # for the password we generate something random
			
			echo $provider_uid."<br>";
			echo $email;
		}
		catch( Exception $e ){
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
    }      
?>