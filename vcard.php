<?php

include ("include/dbconnect.php");
Header("Content-Type: text/x-vCard");

if ($id) {

$sql = "SELECT * FROM $month_from_where AND $table.id=$id";

   $result = mysql_query($sql, $db);
   $links  = mysql_fetch_array($result);
   
   $id = $links["id"];
   $firstname = $links["firstname"];
   $lastname = $links["lastname"];
   $address = $links["address"];
   $home = $links["home"];
   $mobile = $links["mobile"];
   $work = $links["work"];
   $email = $links["email"];
   $email2 = $links["email2"];

   $bday = $links["bday"];
   $bmonth_num = $links["bmonth_num"];
   $byear = $links["byear"];

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