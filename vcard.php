<?php

include ("include/dbconnect.php");

if ($id) {

   $sql = "SELECT * FROM $month_from_where AND $table.id=$id";

   $result = mysql_query($sql, $db);
   $links  = mysql_fetch_array($result);
   
   require "include/export.vcard.php";
   
   header2vcard($links);
   echo address2vcard($links);
	
} else {

	echo "You need to select an ID number of a data entry";

}
?>
