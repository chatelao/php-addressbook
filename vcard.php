<?php

include ("include/dbconnect.php");

Header("Content-Type: text/x-vCard");
// addition by rehan@itlinkonline.com
Header("Content-Transfer-Encoding: 8bit");
// end addition by rehan@itlinkonline.com
if ($id) {

$sql = "SELECT * FROM $month_from_where AND $table.id=$id";
   // addition by rehan@itlinkonline.com
   $phoneSql = 'SELECT * FROM ' . $table_phone . ' p LEFT JOIN ' . $table_phone_type . ' pt on p.phone_type_id = pt.phone_type_id WHERE addressbook_id = ' . $id . ' ORDER BY primary_number desc, phone_type';
   $emailSql = 'SELECT * FROM ' . $table_email . ' e LEFT JOIN ' . $table_email_type . ' et on e.email_type_id = et.email_type_id WHERE addressbook_id = ' . $id . ' ORDER BY primary_email desc, email_type';
   $addressSql = 'SELECT * FROM ' . $table_address . ' a LEFT JOIN ' . $table_address_type . ' at on a.address_type_id = at.address_type_id WHERE addressbook_id = ' . $id . ' ORDER BY primary_address desc, address_type';

   $result = mysql_query($sql, $db);
   $phone = mysql_query($phoneSql, $db);
   $address = mysql_query($addressSql, $db);
   $email = mysql_query($emailSql, $db);
   // end addition by rehan@itlinkonline.com

   $links  = mysql_fetch_array($result);
      
   $firstname  = utf8_to_latin1($links["firstname"]);
   $lastname   = utf8_to_latin1($links["lastname"]);
 
   $bday       = utf8_to_latin1($links["bday"]);
   $bmonth_num = utf8_to_latin1($links["bmonth_num"]);
   $byear      = utf8_to_latin1($links["byear"]);

   // addition by rehan@itlinkonline.com
   Header("Content-disposition: attachement; filename=".$firstname." ".$lastname.".vcf");
   
	  echo "BEGIN:VCARD\n";
	  echo "VERSION:3.0\n";
	  echo "N:$lastname;$firstname;;;;\n";
	  echo "FN:$firstname $lastname\n";
          while($tmpPhone = mysql_fetch_array($phone)){
            echo "TEL;TYPE=".$tmpPhone['phone_type'].",VOICE:".$tmpPhone['phone_number']."\n";
          }
          while($tmpEmail = mysql_fetch_array($email)){
            echo "EMAIL;TYPE=PREF,INTERNET:".$tmpEmail['email_address']."\n";
          }
          while($tmpAddress = mysql_fetch_array($address)){
              $add = str_replace("\r\n", '\n', $tmpAddress['postal_address']);
            echo "ADR;TYPE=".$tmpAddress['address_type'].":;;".$add."\n";
            echo "LAbEL;TYPE=".$tmpAddress['address_type'].":".$add."\n";
          }
	// end addition by rehan@itlinkonline.com
	  echo "BDAY:$byear-".(strlen($bmonth_num) == 1?"0":"")."$bmonth_num-$bday\n";
	  echo "END:VCARD\n";
	
} else {
	echo "You need to select an ID number of a data entry";
	}
?>