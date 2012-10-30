<?php

  include dirname(__FILE__).DIRECTORY_SEPARATOR."cfg.db.php";
  include dirname(__FILE__).DIRECTORY_SEPARATOR."cfg.user.php";   

  include dirname(__FILE__).DIRECTORY_SEPARATOR."cfg.sso.php";
  include dirname(__FILE__).DIRECTORY_SEPARATOR."cfg.mail.php";   
  include dirname(__FILE__).DIRECTORY_SEPARATOR."cfg.guess.php";   
  
  // Page access configuration
  $page_ext   = ".php";

  //
  // Select the columns displayed in "index.php":
  $disp_cols
    = array( "select"
           , "photo"
           // , "lastname"
           // , "firstname"
           , "last_first"
           , "address"
           , "all_emails"
           // , "email"
           , "all_phones"
           // , "telephone"
           // , "home"
           // , "mobile"
           // , "work"
           // , "fax"
           , "edit"
           , "details"
           );

  // Enable quick adding of unstructured addresses
  $quickadd = true;

  // Don't display groups
  $nogroups = false;

  // Disable all "edit/create" actions
  $read_only  = false;

  // Enable group administration pages
  $public_group_edit = true;

  // Disable the AJAX-Mode with "false"
  $use_ajax = true;

  // Enable beta fetures, not recommended for production.
  $beta_features = false;

  // View e-mail addresses as images
  $mail_as_image = false;

  // Change the location of the images (e.g. a CDN Source)
  $url_images = "";

  // Disable HTTP-Compression with 0
  $compression_level = 2;
  
?>