<?php

function address2vcard($links) {
	
   $firstname  = utf8_to_latin1($links["firstname"]);
   $lastname   = utf8_to_latin1($links["lastname"]);
   $address    = utf8_to_latin1($links["address"]);
   $home       = utf8_to_latin1($links["home"]);
   $mobile     = utf8_to_latin1($links["mobile"]);
   $work       = utf8_to_latin1($links["work"]);
   $fax        = utf8_to_latin1($links["fax"]);
   $email      = utf8_to_latin1($links["email"]);
   $email2     = utf8_to_latin1($links["email2"]);
 
   $bday       = utf8_to_latin1($links["bday"]);
   $bmonth_num = utf8_to_latin1($links["bmonth_num"]);
   $byear      = utf8_to_latin1($links["byear"]);

	 $result  = "BEGIN:VCARD\n";
	 $result .= "VERSION:2.1\n";
	 $result .= "N:$lastname;$firstname;;;;\n";
	 $result .= "FN:$firstname $lastname\n";
	 $result .= "TEL;HOME;VOICE:$home\n";
	 $result .= "TEL;cell;VOICE:$mobile\n";
	 $result .= "TEL;work;VOICE:$work\n";
	 $result .= "TEL;fax:$fax\n";
	 $result .= "EMAIL;PREF;INTERNET:$email2\n";
	 $result .= "EMAIL;PREF;INTERNET:$email\n";
	 $result .= "BDAY:$byear-".(strlen($bmonth_num) == 1?"0":"")."$bmonth_num-$bday\n";
	 $result .= "END:VCARD\n";
	 
	 return $result;

}

?>