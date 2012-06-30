<?php

  //
  // == List of Login/Pass-Users ==
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

  //
  // == User table in database ==
  //
  $usertable = "user";

  // == List of IP-Users ==
  //
  /*
  // Autorize one IP-Address
  $iplist['169.168.1.42']['role']      = "admin";

  // Autorize an IP-Range
  $iplist['169.168.1.*']['role']      = "readonly";
  $iplist['169.168.1.1-100']['role']  = "readonly";

  // Block an IP-Address
  $blacklist['169.168.1.5'] = "";
  */


  //
  // == Look & Feel of the domains
  //
  // $skin_color = "blue"; // global skin color

  // blue, brown, green, grey, pink, purple, red, turquoise, yellow
  $domain[0]['skin'] = "blue";
  $domain[1]['skin'] = "pink";
  $domain[2]['skin'] = "yellow";

?>