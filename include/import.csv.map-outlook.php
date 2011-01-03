<?php

     $off = (isset($off) ? $off : 0);
     
  	 $addr = array();
  	 $addr['lastname']  = getIfSet($rec, $off+3);
  	 $addr['firstname'] = getIfSet($rec, $off+1).(getIfSet($rec, $off+2) != "" ? " ".getIfSet($rec, $off+2) : "");
  	 $addr['company']   = getIfSet($rec, $off+5);

     $date_parts        = explode(".", getIfSet($rec, $off+65));
     if(count($date_parts) == 3 && $date_parts[0] != 0) {
  	   $addr['bday']      = ltrim($date_parts[0],"0");
  	   $addr['bmonth']    = MonthToName($date_parts[1]);
  	   $addr['byear']     = $date_parts[2];
  	 }
  	 
  	 $addr['address']   = getIfSet($rec, $off+15)."\n"
  	                     .getIfSet($rec, $off+20)." ".getIfSet($rec, $off+18);

     // tbd: improved guess of all possible # (rows 30-48)
  	 $addr['home']      = getIfSet($rec, $off+37);
  	 $addr['mobile']    = getIfSet($rec, $off+40);
  	 $addr['work']      = getIfSet($rec, $off+31);
  	 $addr['fax']       = getIfSet($rec, $off+30);

  	 $addr['email']     = (getIfSet($rec, $off+56) == "SMTP" ? getIfSet($rec, $off+55) : "");
  	 $addr['email2']    = (getIfSet($rec, $off+59) == "SMTP" ? getIfSet($rec, $off+58) : "");
  	 
  	 $addr['homepage']  = getIfSet($rec, $off+90);

  	 $addr['address2']  = getIfSet($rec, $off+8)."\n"
  	                     .getIfSet($rec, $off+13)." ".getIfSet($rec, $off+11);
  	                     
  	 $addr['phone2']    = getIfSet($rec, $off+42);

?>