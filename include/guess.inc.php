<?php

// Default list of external phone book providers,
// may be overridden in "config.php"
if(!isset($providers))
{
	$providers = array( "+33" => array("name" => "pagesblanches.fr"
	                                  ,"url"  => "http://www.pagesjaunes.fr/pagesblanches/rechercheInverse.do?portail=PJ&numeroTelephone=")
	                  , "+39" => array("name" => "paginebianche.it"
	                                  ,"url"  => "http://www.paginebianche.it/execute.cgi?btt=1&ts=106&rk=&qs=")
	                  , "+41" => array("name" => "local.ch"
	                                  ,"url"  => "http://www.local.ch/de/q/?what=")
	                  , "+43" => array("name" => "herold.at"
	                                  ,"url"  => "http://www.herold.at/servlet/at.herold.sp.servlet.SPWPSearchServlet?searchterm=")
	                  , "+49" => array("name" => "dastelefonbuch.de"
	                                  ,"url"  => "http://www1.dastelefonbuch.de/Rueckwaerts-Suche.html?cmd=search&kw=")
	                  );
}

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
                       , "eml.cc"
                       , "freesurf.ch"
                       , "freenet.de"
                       , "gmail.com"
                       , "googlemail.com"
                       , "gmx."
                       , "hispeed.ch"
                       , "hotmail."
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

	if($email1 != "") {
	$homepage = guessOneHomepage($email1);
	if(strlen($homepage) > 0)
	{
		return $homepage;
	}
  }

	if($email2 != "") {
	$homepage = guessOneHomepage($email2);
	if(strlen($homepage) > 0)
	{
		return $homepage;
	}
	}

	return "";

}

function guessAddressFields($address) {
	
  global $company_exts, $title_exts;
  
  if(!isset($company_exts)) $company_exts = array();
  if(!isset($title_exts))   $title_exts   = array();

  $new_addr_list = array();

	$address = preg_replace("/--(-)*/", "", $address);
	$address = preg_replace("/__(_)*/", "", $address);
	$address = preg_replace("/==(=)*/", "", $address);
  //
  // Preprocess:
  // * Revert "mysql_real_escape"
  // * Split into block (newline, pipe, colon)
  // * Remove whitespaces & empty lines
  //  
	$address = stripslashes($address);
	$addr_list = preg_split("/(\n|\s?[*|,-]\s)/", $address);
	for($i = 0; $i < count($addr_list); $i++) {
		$addr_line = $addr_list[$i];
		$addr_line = trim($addr_line);
		if($addr_line != "" && $addr_line != null) {
		  $new_addr_list[] = $addr_line;
	  }
	}
	$addr_list = $new_addr_list;

	$is_phone = false;
	$is_url   = false;
	
	$unparsed_addr_lines = array();
	$phones    = array();
	$mails     = array();
	// $company   = "";
	// $homepage  = "";

	$firstname = "";
	$lastname  = "";
  $has_name  = false;
	
	for($i = 0; $i < count($addr_list); $i++) {
		
		$addr_line = $addr_list[$i];
		$addr_line = str_replace("(at)",  "@", $addr_line);
		$addr_line = str_replace("{at}",  "@", $addr_line);
		$addr_line = str_replace("'at'",  "@", $addr_line);
		$addr_line = str_replace("'dot'", ".", $addr_line);
		$keep_line = true;
		
		if(function_exists("mb_strtoupper")) {
		  $addr_line_upper = mb_strtoupper($addr_line);
		} else {
		  $addr_line_upper = strtoupper($addr_line);
		}

                         
	  if((!isset($company) || $company == "")
	     && preg_match("/ (".implode("|", $company_exts).")(\W|$)/", strtoupper($addr_line), $matches) > 0) {
	  	$company = $addr_line;
		  $keep_line = false;
	  } elseif((!isset($title) || $title == "")
	     && preg_match("/(^| )(".implode("|", $title_exts).")(\W|$)/", strtoupper($addr_line), $matches) > 0) {
	  	$title = $addr_line;
		  $keep_line = false;
	  } else

    //
    // Vorname Nachname
    //
	  if(! $has_name) {
	  	$names = explode(" ", $addr_line, 2);
	  	$firstname = $names[0];
	  	$lastname  = "";
	  	if(count($names) > 1) {
	  	  $lastname = $names[1];
	  	}
		  $keep_line = false;
		  $has_name  = true;
	  }

    //
    // Mailadressen
    //
	  elseif(preg_match("/([A-Za-z0-9\.\-_])*\@([A-Za-z0-9\.\-_])*\.([A-Za-z]){2,3}/", $addr_line, $matches) > 0) {
	  	$mails[] = $matches[0];
		  $keep_line = false;
	  }

    //
    // Webseiten:
    // * http://
    // * https://
    // * www.
    //
  	elseif((    !isset($homepage) 
  	         || $homepage == "")
  	       && preg_match("/(http(s)?:\/\/|www\.)([A-Za-z\.\-_])*\.([A-Za-z]){2,3}([\/A-Za-z\.\-_])*/", $addr_line, $matches) > 0) {
  		$homepage = $matches[0];
  		$homepage = str_replace("http://", "", $homepage);
		  $keep_line = false;
  	}

    //
    // Telefonnummern
    //
	  elseif(preg_match("/(\+)?([0-9\(\)])+([0-9\(\) -\/'])*/", $addr_line, $matches) > 0) {
	  	$phone_number = $matches[0];

	  	$phone_type = "";

	  	// Telefon, Fon, Privat(e), Home
      $phone_exts = array("TEL P",  "P", "PRIVATE"
                         ,"TEL H",  "H", "HOME"
                         // , "T", "TEL", "TELEFON", "TELEPHON", "TELEPHONE", "PHONE"
                         // , "FON"
                         );
	    if(preg_match("/^(".implode("|", $phone_exts).")(\.)?(:)?(\s)+/", $addr_line_upper, $matches) > 0) {
	  	  $phone_type = "HOME";
	    }
	  	
	  	// Mobil(e), Natel, Cell
      $phone_exts = array("TEL M", "M", "MOBIL", "MOBILE", "N", "NATEL", "C", "CELL");
	    if(preg_match("/^(".implode("|", $phone_exts).")(\.)?(:)?(\s)+/", $addr_line_upper, $matches) > 0) {
	  	  $phone_type = "CELL";
	    }
	  	
	  	// Geschäft, Business
      $phone_exts = array("TEL G", "G", "GESCHÄFT", "B", "BUSINESS");
	    if(preg_match("/^(".implode("|", $phone_exts).")(\.)?(:)?(\s)+/", $addr_line_upper, $matches) > 0) {
	  	  $phone_type = "WORK";
	    }
	  	
	  	// Fax, Facsmile
      $phone_exts = array("F", "FAX", "TELEFAX");
	    if(preg_match("/^(".implode("|", $phone_exts).")(\.)?(:)?(\s)+/", $addr_line_upper, $matches) > 0) {
	  	  $phone_type = "FAX";
	    }
	  	
	  	if(strlen($phone_number) > 6) {
	  	  $phones[$phone_type][] = $phone_number;
		    $keep_line = false;
	  	}
	  }
	  if($keep_line) {
	  	$unparsed_addr_lines[] = $addr_line;
	  }
	}

	//
	// Redistribute the phone numbers
	//
	$phone_types   = array('WORK', 'FAX', 'HOME', 'CELL');
	$phone_targets = array('work', 'fax', 'home', 'mobile', 'phone2');
	
  for($i = 0; $i < count($phone_types); $i++) {
    $phone_type   = $phone_types[$i];
    $phone_target = $phone_targets[$i];
    if(isset($phones[$phone_type])) {
    	 $$phone_target = $phones[$phone_type][0];
    }
	}
	
	// Better distribution of "neutral" phone types
	// * If fax OR company is set + Business empty => business phone
	// Else: Privat or Phone2
	if(isset($phones['']) && count($phones['']) > 0) {
    if(isset($phones['FAX']) && count($phones['FAX']) > 0 && !isset($phones['WORK'])) {
    	$work = $phones[''][0];
    } elseif(!isset($phones['HOME'])) {
    	$home = $phones[''][0];			
    } else {
    	$phone2 = $phones[''][0];
    }
    
    $phone_type = '';
  	for($j = 1; $j < count($phones[$phone_type]); $j++) {
 	    foreach($phone_targets as $phone_target) {
 	      if(!isset($$phone_target) || $$phone_target == "") {
 	   	 	  $$phone_target = $phones[$phone_type][$j];
 	   	 	  break;
 	   	  }
 	    }
  	}
	}
	
  for($i = 0; $i < count($phone_types); $i++) {
    $phone_type   = $phone_types[$i];
    $phone_target = $phone_targets[$i];
    if(isset($phones[$phone_type]) && count($phones[$phone_type]) > 1) {
    	 for($j = 1; $j < count($phones[$phone_type]); $j++) {
    	   foreach($phone_targets as $phone_target) {
    	   	 if(!isset($$phone_target) || $$phone_target == "") {
    	   	 	 $$phone_target = $phones[$phone_type][$j];
    	   	 	 break;
    	   	 }
    	   }
      }
    }
	}
	
	if(isset($firstname)) $result['firstname'] = $firstname;
	if(isset($lastname))  $result['lastname']  = $lastname;
	if(isset($company))   $result['company']   = $company;
	if(isset($title))     $result['title']     = $title;

	$result['address']   = implode("\n", $unparsed_addr_lines);

	if(isset($home))     $result['home']   = $home;
  if(isset($mobile))   $result['mobile'] = $mobile;
  if(isset($work))     $result['work']   = $work;
	if(isset($fax))      $result['fax']    = $fax;
	if(isset($phone2))   $result['phone2'] = $phone2;

	if(isset($mails[0])) $result['email']  = $mails[0];
	if(isset($mails[1])) $result['email2'] = $mails[1];

	if(isset($homepage)) $result['homepage'] = $homepage;
	
	return $result;
}

?>