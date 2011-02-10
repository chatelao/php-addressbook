<?php

  // Database access definition
  $dbname     = "your_database"; 
  $dbserver   = "localhost"; 
  $dbuser     = "username"; 
  $dbpass     = "password"; 

  // Define table prefix
  $table_prefix = ""; 

  /* 
  // Your key to enable "Google Maps" support (optional):
  // * http://code.google.com/intl/en-US/apis/maps/signup.html
  $google_maps_keys['yourdomain.com'] = "XXXXXXXXX_YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY_ZZZZZZZZZZZZZZZZZZ_AAAAAAAAAAAAAAA";
  */
  
  //
  // List of Login/Users:
  //
  /*  
  // -- Setup an "admin" user, with password "secret" --
  $userlist['admin']['pass'] = "secret";
  $userlist['admin']['role'] = "root"; // used to call "/diag.php"

  // Setup a "readonly" user
  $userlist['view']['pass']  = "apassword";
  $userlist['view']['role']  = "readonly";  

  // Setup a user accessing only one group
  $userlist['mygroup']['pass']  = "apassword";
  $userlist['mygroup']['group'] = "My group";

  // Setup a user for the second domain (0 = default)
  $userlist['adm2']['pass']   = "adm2";
  $userlist['adm2']['domain'] = 1;
  */

  // Don't display groups
  $nogroups = false;

  // blue, brown, green, grey, pink, purple, red, turquoise, yellow
  $domain[0]['skin'] = "blue";
  $domain[1]['skin'] = "pink";
  $domain[2]['skin'] = "yellow";

  // == List of IP-Users ==
  //
  /*
  $iplist['169.168.1.1']['role']  = "admin";
  $iplist['169.168.1.1']['role']  = "readonly";
  */

  //
  // Select displayed columns in "index.php"
  // - EARLY BETA!! (Search may not work well)
  //
  /*
  $disp_cols
    = array( "select"
           , "first_last"
           , "last_first"
           , "lastname"
           , "firstname"
           , "address"
           , "email"
           , "telephone"
           , "home"
           , "mobile"
           , "work"
           , "fax"
           , "edit"
           , "details" );
  */  

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

  // Disable all "edit/create" actions
  $read_only  = false;

  // Enable group administration pages
  $public_group_edit = true;

  // Keep a history of all changes, incl. deletion. Used for intelligent merge.
  $keep_history = true;

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