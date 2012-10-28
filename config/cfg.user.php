<?php

  //
  // == List of Login/Pass-Users ==
  //
  // -- Setup an "admin" user, with password "secret" --
  $userlist['admin']['pass'] = "secret";
  $userlist['admin']['role'] = "root"; // used to call "/diag.php"

  //*  
  // -- Setup readonly-user for regression tests (yourdomain.com/addressbook/test/
  $userlist['simpletest']['pass']   = "simple";
  $userlist['simpletest']['role']   = "readonly";  
  $userlist['simpletest']['domain'] = 9999;
  //*/

  /*  
  // Setup a "readonly" user
  $userlist['view']['pass']  = "apassword";
  $userlist['view']['role']  = "readonly";  

  // Setup a user accessing only one group
  $userlist['mygroup']['pass']  = "apassword";
  $userlist['mygroup']['group'] = "My group";

  // Setup a user for the second domain (0 = default)
  $userlist['adm2']['pass']   = "adm2";
  $userlist['adm2']['domain'] = 1;
  //*/

  //
  // == User table in database ==
  // - Excludes the table_prefix!
  $usertable = "users";

  // == List of IP-Users ==
  //
  /*
  $iplist['169.168.1.1']['role']  = "admin";
  $iplist['169.168.1.1']['role']  = "readonly";
  */


  //
  // == Look & Feel of the domains
  //
  $skin_color = "red"; // global skin color, e.g. on login

  // blue, brown, green, grey, pink, purple, red, turquoise, yellow
  $domain[0]['skin'] = "red";
  $domain[1]['skin'] = "pink";
  $domain[2]['skin'] = "yellow";

?>