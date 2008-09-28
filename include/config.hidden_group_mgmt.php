<?php
  // Database access definition
  $dbname     = "your_database"; 
  $dbserver   = "localhost"; 
  $dbuser     = "username"; 
  $dbpass     = "password"; 

  // Data storage configuration
  $table        = "addressbook";
  $month_lookup = "month_lookup";

  // (optional) group function
  $table_groups  = "group_list";
  $table_grp_adr = "address_in_groups";

  // Show only one group
  $fixgroup = false;

  // Show link to "group-edit" menu
  // !!! $public_group_edit = true; !!!
  $public_group_edit = false;

  // Page access configuration
  $page_ext   = ".php";

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

  // Disable all "edit/create" actions.
  $read_only  = false;

  // Setup for "Country guessing" (Beta: Switzerland, US, Belgium)
  $map_guess  = true;

?>