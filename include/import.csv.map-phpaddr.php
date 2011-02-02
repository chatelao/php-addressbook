<?php

  	 $addr = array();
  	 $addr['lastname']  = getIfSet($rec,0);
  	 $addr['firstname'] = getIfSet($rec,1);
  	 $addr['company']   = ""; // tbd at export

     $date_parts        = explode(".", getIfSet($rec,2));
     if(count($date_parts) == 3) {
  	   $addr['bday']      = ltrim($date_parts[0],"0");
  	   $addr['bmonth']    = MonthToName($date_parts[1]);
  	   $addr['byear']     = $date_parts[2];
  	 }
  	 
  	 $addr['address']   = getIfSet($rec,3)."\n"
  	                     .getIfSet($rec,4)." ".getIfSet($rec,5);
                        
  	 $addr['home']      = getIfSet($rec,6);
  	 $addr['mobile']    = getIfSet($rec,7);
  	 $addr['work']      = getIfSet($rec,9);
  	 $addr['fax']       = getIfSet($rec,10);
  	                    
  	 $addr['email']     = getIfSet($rec,8);
  	 $addr['email2']    = getIfSet($rec,11);
  	                    
  	 $addr['address2']  = str_replace(", ", "\n", getIfSet($rec,12));
  	 $addr['phone2']    = getIfSet($rec,13);	 
  	 
?>