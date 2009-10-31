<?php

  // Database access definition
  $dbname     = "your_database"; 
  $dbserver   = "localhost"; 
  $dbuser     = "username"; 
  $dbpass     = "password"; 
  
  // List of Login-Users
  // $userlist['admin'] = "secret";
  // $userlist['user2'] = "pass2";
  // ...

  // Define table prefix
  $table_prefix = "";
  
  // Don't display groups
  $nogroups = false;

  // Disable all "edit/create" actions.
  $read_only  = false;

  // Enable group administration pages
  $public_group_edit = true;

  // Usual languages of your visitors:
  // - United Nation Organisation (UNO)
  $default_languages = "ar,zh,en,es,fr,ru";
  //
  // - Western Europe
  // $default_languages = "ca,de,en,es,fr,it,nl,se";
  // - Eastern Europe
  // $default_languages = "bg,cz,es,gr";
  //
  // - Both Americas
  // $default_languages = "en,es,fr,pt";
  //
  // - Western Asia
  // $default_languages = "en,he,hi";
  // - Eastern Asia
  // $default_languages = "cn,jp,ko,th,vi";
  //
  // - Africa
  // $default_languages = "ar,fr,nl";


  // List of excluded sites in "Homepage guessing"
  $free_mailers = array( "a3.epfl.ch"
                       , "acm.org"
                       , "aol.com"
                       , "bigfoot.com"
                       , "bluewin.ch"
                       , "bluemail.ch"
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
                       , "t-online.de"
                       , "web.de"
                       , "yahoo."
                      );

  // Setup for "Country guessing" (Beta: Switzerland, US, Belgium)
  $map_guess  = true;

  // Setup language usage (auto, choose, en, de)
  $lang  = 'choose';
  
  // Change the location of the images (e.g. Google Appspot)
  $url_images = "";

  // Change or ommit page-extension in URL
  $page_ext   = ".php";

  // Disable HTTP-Compression with 0
  $compression_level = 2;
  
  // Disable the AJAX-Mode with "false"
  $use_ajax = true;
?>