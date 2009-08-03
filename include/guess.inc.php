<?php

// Default list of free_mailers,
// may be overridden in "config.php"
if(!isset($free_mailers))
{

  global $free_mailers;

  // List of excluded sites in "Homepage guessing"
  $free_mailers = array( "a3.epfl.ch"
                       , "acm.org"
                       , "aol.com"
                       , "bigfoot.com"
                       , "bluewin.ch"
                       , "bluemail.ch"
                       , "email.ch"
                       , "freesurf.ch"
                       , "gmail.com"
                       , "gmx."
                       , "hotmail.com"
                       , "ieee.org"
                       , "intergga.ch"
                       , "msn."
                       , "pobox.com"
                       , "swissonline.ch"
                       , "spectraweb.ch"
                       , "tiscalinet.ch"
                       , "t-online.de"
                       , "web.de"
                       , "yahoo."
                      );
}

function guessOneHomepage($email) {

	global $free_mailers;

	$homepage = substr($email, strpos($email, '@')+1);
        foreach ($free_mailers as $free_mailer)
        {
              if( strpos($homepage, $free_mailer) !== FALSE && strpos($homepage, $free_mailer) == 0)
              {
	             $homepage = "";
	      }
        }

	if(strlen($homepage) == 0)
	{
		return "";
	} else {
		return "www.$homepage";
	}
}


function guessHomepage($email1, $email2) {

	$homepage = guessOneHomepage($email1);
	if(strlen($homepage) > 0)
	{
		return $homepage;
	}

	$homepage = guessOneHomepage($email2);
	if(strlen($homepage) > 0)
	{
		return $homepage;
	}

	return "";

}

?>