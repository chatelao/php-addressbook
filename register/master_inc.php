<?php
//no space before <?
  include"login_config.php";
  require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR . "mysqli.database.php";

   if(!isset($db_access)) {
     $db_access = new MysqliDatabase();
   }

   // connect to the server
   $db_access->connect( $db_host, $db_username, $db_password )
      or die( "Error! Could not connect to database: " . $db_access->error() );

   // select the database
   $db_access->selectDb( $db )
      or die( "Error! Could not select the database: " . $db_access->error() );

?>
