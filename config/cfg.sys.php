<?php
  
  // Database access definition
  $dbname       = "test";      // your database name
  $dbserver     = "localhost"; // your database hostname
  $dbuser       = "root";      // your database username     
  $dbpass       = "";          // your database password     
  // Read-Only user for increasd security (optional):
  // * GRANT SELECT ON $dbname.addressbook       TO $dbuser_read
  // * GRANT SELECT ON $dbname.group_list        TO $dbuser_read
  // * GRANT SELECT ON $dbname.address_in_groups TO $dbuser_read
  // * GRANT SELECT ON $dbname.month_lookup      TO $dbuser_read
  // $dbuser_read       = "root";      // your database username     
  // $dbpass_read       = "";          // your database password     

  // Keep a history of all changes, incl. deletion. Used for intelligent merge.
  $keep_history = true;

  // You may use a table-prefix if you have only one DB-User
  $table_prefix = "";


  // IMAP connection string (optional) for "email_in.php"
  // - See: http://www.php.net/manual/de/function.imap-open.php
  // $mail_box  = "{imap.gmail.com:993/imap/ssl}INBOX";
  // $mail_user = "firstname.lastname@gmail.com";
  // $mail_pass = "mysecretpassword";
?>