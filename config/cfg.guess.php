<?php

  // === enable/disable guessing options ==

  // List external phonebook providers
  $default_provider = "+41";
   
  // Guess homepage from e-mail, excluding the freemailers defined below
  $homepage_guess  = true;

  // Setup for "Country guessing" (Beta: Switzerland, US, Belgium)
  $map_guess  = true;

  // === static lookup tables ==

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

?>