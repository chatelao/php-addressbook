<?php

include ("include/dbconnect.php");

if ($id) {

   $sql = "SELECT * FROM $month_from_where AND $table.id=$id";

   $result = mysql_query($sql, $db);
   $links  = mysql_fetch_array($result);
   
   Header("Content-Type: text/x-vCard");
   $filename = utf8_to_latin1($links['firstname'].'_'.$links['lastname']."-".date("Y_m_d-Hi"));
   Header('Content-Disposition: attachment; filename="'.$filename.'.vcf"');
   require "include/export.vcard.php";
   echo address2vcard($links);
	
} else {

	echo "You need to select an ID number of a data entry";

}
?>
