<?php

  // Database access definition
  $dbname     = "addressbook"; 
  $dbserver   = "localhost"; 
  $dbuser     = "root"; 
  $dbpass     = "root"; 
  
  // == List of Login-Users ==
  // $userlist['admin']['pass'] = "secret";
  //
  // -- Role "readonly": --
  // $userlist['view']['pass'] = "apassword";
  // $userlist['view']['role'] = "readonly";  

  // Define table prefix
  $table_prefix = "";
  
  // Don't display groups
  $nogroups = false;

  // Disable all "edit/create" actions
  $read_only  = false;

  // Enable group administration pages
  $public_group_edit = true;

  // View e-mail addresses as images
  $mail_as_image = false;

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