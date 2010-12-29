<?php

  	 $addr = array();
  	 $addr['lastname']  = $rec[0];
  	 $addr['firstname'] = $rec[1];
  	 $addr['company']   = ""; // tbd at export

     $date_parts        = explode(".", $rec[2]);
     if(count($date_parts) == 3) {
  	   $addr['bday']      = ltrim($date_parts[0],"0");
  	   $addr['bmonth']    = MonthToName($date_parts[1]);
  	   $addr['byear']     = $date_parts[2];
  	 }
  	 
  	 $addr['address']   = $rec[3]."\n"
  	                     .$rec[4]." ".$rec[5];
                        
  	 $addr['home']      = $rec[6];
  	 $addr['mobile']    = $rec[7];
  	 $addr['work']      = $rec[9];
  	 $addr['fax']       = $rec[10];
  	                    
  	 $addr['email']     = $rec[8];
  	 $addr['email2']    = $rec[11];
  	                    
  	 $addr['address2']  = str_replace(", ", "\n", $rec[12]);
  	 $addr['phone2']    = $rec[13];
  	 
?>  	 