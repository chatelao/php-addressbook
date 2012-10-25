<?php
  
  // Database access definition
  $dbserver     = "localhost"; // your database hostname
  $dbname       = "test";      // your database name
  $dbuser       = "root";      // your database username     
  $dbpass       = "";          // your database password     

  // Read-Only user for increasd security (optional):
  // * GRANT SELECT ON $dbname.addressbook       TO $dbuser_read
  // * GRANT SELECT ON $dbname.group_list        TO $dbuser_read
  // * GRANT SELECT ON $dbname.address_in_groups TO $dbuser_read
  // * GRANT SELECT ON $dbname.month_lookup      TO $dbuser_read
  // $dbuser_read       = "root";      // your database username     
  // $dbpass_read       = "";          // your database password     

  // You may use a table-prefix if you have only one DB-User
  $table_prefix = "";

  // Keep a history of all changes, incl. deletion. Used for intelligent merge.
  $keep_history = true;

?>