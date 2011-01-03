<?php

     $off = (isset($off) ? $off : 0);
     
  	 $addr  = array();
  	 $names = explode(" ", getIfSet($rec, $off+3));
  	 $addr['firstname'] = array_pop($names);
  	 if($addr !== NULL) {
  	   $addr['lastname'] = implode(" ", $names);
  	 }

     // tbd: improved guess of all possible # (rows 30-48)
  	 $addr['home']      = getIfSet($rec, $off+13);
  	 $addr['mobile']    = getIfSet($rec, $off+14);
  	 $addr['work']      = getIfSet($rec, $off+28);
  	 
  	 //
  	 // Write line+result to HTML
  	 //
  	 $debug_import = false;
  	 if($debug_import) {
       print_r($rec);
  	   print_r($addr);  	 
  	 }

?>