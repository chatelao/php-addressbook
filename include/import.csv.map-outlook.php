<?php

  	 $addr = array();
  	 $addr['lastname']  = $rec[3];
  	 $addr['firstname'] = $rec[1].($rec[2] != "" ? " ".$rec[2] : "");
  	 $addr['company']   = $rec[5];

     $date_parts        = explode(".", $rec[65]);
     if(count($date_parts) == 3 && $date_parts[0] != 0) {
  	   $addr['bday']      = ltrim($date_parts[0],"0");
  	   $addr['bmonth']    = MonthToName($date_parts[1]);
  	   $addr['byear']     = $date_parts[2];
  	 }
  	 
  	 $addr['address']   = $rec[15]."\n"
  	                     .$rec[20]." ".$rec[18];

     // tbd: improved guess of all possible # (rows 30-48)
  	 $addr['home']      = $rec[37];
  	 $addr['mobile']    = $rec[40];
  	 $addr['work']      = $rec[31];
  	 $addr['fax']       = $rec[30];

  	 $addr['email']     = ($rec[56] == "SMTP" ? $rec[55] : "");
  	 $addr['email2']    = ($rec[59] == "SMTP" ? $rec[58] : "");

  	 $addr['address2']  = $rec[8]."\n"
  	                     .$rec[13]." ".$rec[11];
  	                     
  	 $addr['phone2']    = $rec[42];

?>