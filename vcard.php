<?php

include ("include/dbconnect.php");

Header("Content-Type: text/x-vCard");

if ($id) {

$sql = "SELECT * FROM $month_from_where AND $table.id=$id";

   $result = mysql_query($sql, $db);
   $links  = mysql_fetch_array($result);
      
   $firstname  = utf8_to_latin1($links["firstname"]);
   $lastname   = utf8_to_latin1($links["lastname"]);
   $address    = utf8_to_latin1($links["address"]);
   $home       = utf8_to_latin1($links["home"]);
   $mobile     = utf8_to_latin1($links["mobile"]);
   $work       = utf8_to_latin1($links["work"]);
   $email      = utf8_to_latin1($links["email"]);
   $email2     = utf8_to_latin1($links["email2"]);
 
   $bday       = utf8_to_latin1($links["bday"]);
   $bmonth_num = utf8_to_latin1($links["bmonth_num"]);
   $byear      = utf8_to_latin1($links["byear"]);

   Header('Content-Disposition: attachment; filename="'.$firstname.'_'.$lastname."_".$id."-".date("Ymd").'.vcf"');

	  echo "BEGIN:VCARD\n";
	  echo "VERSION:2.1\n";
	  echo "N:$lastname;$firstname;;;;\n";
	  echo "FN:$firstname $lastname\n";
	  echo "TEL;HOME;VOICE:$home\n";
	  echo "TEL;cell;VOICE:$mobile\n";
	  echo "TEL;work;VOICE:$work\n";
	  echo "EMAIL;PREF;INTERNET:$email2\n";
	  echo "EMAIL;PREF;INTERNET:$email\n";
	  echo "BDAY:$byear-".(strlen($bmonth_num) == 1?"0":"")."$bmonth_num-$bday\n";
	  echo "END:VCARD\n";
	
} else {

	echo "You need to select an ID number of a data entry";

	}
?>
