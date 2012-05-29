<?php

  // === enable/disable guessing options ==

  // List external phonebook providers
  $default_provider = "+41";
   
  // Guess homepage from e-mail, excluding the freemailers defined below
  $homepage_guess  = true;

  // Setup for "Country guessing" (Beta: Switzerland, US, Belgium)
  $map_guess  = true;

  // Pattern for PLZ guessing
  $plz_pattern = "[0-9A-Z]{4,8}";

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

  //
  // Companies postfixes
  //
  $company_exts = array( "INC"
                       , "LTD"
                       , "PLC"
                       , "HOTEL"
                       , "MOTEL"
                       , "REST."
                       , "RESTAURANT"

                       , "SA"
                       , "SARL"

                       , "AB"

                       , "AG"
                       , "AMT "
                       , "DEPARTEMENT"
                       , "GMBH" );

  //
  // Title
  //
  $title_exts = array( 
                     //
                     // English
                     //
                       "ADVISOR"
                     , "ANALYST"
                     , "ARCHITECT"
                     , "ASSISTANT"
                     , "ASSOCIATE"
                     , "C\w?O"
                     , "CHAIR(WO)?MAN"
                     , "CHIEF"
                     , "CONSULTANT"
                     , "COUNSEL"
                     , "COUNSELOR"
                     , "\\w*DIRECTOR"
                     , "\\w*ENGINEER"
                     , "\\w*EXECUTIVE"
                     , "\\w*EXPERT"
                     , "FOUNDER"
                     , "HEAD"
                     , "\\w*LEAD(ER)?"
                     , "\\w*MANAGER"
                     , "MEMBER"
                     , "METHODOLOGIST"
                     , "\\w*OFFICER"
                     , "OWNER"
                     , "PRESIDENT"
                     , "PROPRIETOR"
                     , "SPECIALIST"
                     , "SURGEON"
                     , "WRITER"

                     //
                     // French
                     //
                     , "ADJOINT"
                     , "DÉVELOPPEUR"
                     , "INTÉGRATEUR"

                     //
                     // German
                     //
                     , "\\w*ADMINISTRATOR(IN)"
                     , "\\w*(ANTWALT|ANTWÄTIN)" 
                     , "\\w*ASSISTENT(IN)?" 
                     , "\\w*ARZT|\\w*ÄRZTIN" 
                     , "\\w*ARCHITEKT(IN)?" 
                     , "\\w*BERATER(IN)?"
                     , "\\w*BETRIEBS(RAT|RÄTIN)?"
                     , "\\w*BETREUER(IN)?"
                     , "\\w*DIREKTOR(IN)"
                     , "\\w*DOZENT(IN)"
                     , "\\w*ENTWICKLER(IN)?"
                     , "\\w*FÜHRER(IN)?"
                     , "\\w*FÜRSPRECHER(IN)?"
                     , "\\w*INFORMATIKER(IN)?"
                     , "\\w*INGENIEUR(IN)?"
                     , "\\w*INHABER(IN)?"
                     , "\\w*KURIER(IN)"
                     , "\\w*LEITER(IN)?"
                     , "\\w*MITGLIED"
                     , "\\w*MODERATOR"
                     , "\\w*PARTNER(IN)?"
                     , "\\w*PRÄSIDENT(IN)?"
                     , "\\w*PROFESSOR(IN)"
                     , "\\w*SEKRETÄR(IN)?"
                     , "\\w*SPEZIALIST(IN)"
                     , "\\w*UNTERNEHMER(IN)"
                     , "\\w*VERANTWORTLICHE(R)?"
                     , "\\w*VERWALTUNGS(RAT|RÄTIN)"
                     , "\\w*VORSTEHER(IN)?"
                     , "\\w*VORSITZENDE(R)?"
                     
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