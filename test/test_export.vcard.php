<?php

// Code
include "../include/export.vcard.php";
// Data
include "export.vcard/testdata_label2adr.php";

echo count($tests)." tests starting.<br>";

foreach($tests as $test) {
	
	$expected = $test['output'];
	$result   = label2adr($test['input']);
	
	
	$diff = array_merge( array_diff($expected, $result)
	                   , array_diff($result, $expected));

  if(count($diff) > 0) {
	
	  echo "Input:<br><pre>";
    print_r($test['input']);
	  echo "</pre>";
    
	  echo "Result:<br><pre>";
    print_r($result);
	  echo "</pre>";
    
	  echo "DIFF:<br><pre>";
    print_r($diff);
	  echo "</pre><hr>";
	  
	}
}

echo count($tests)." tests successful finished.<br>";

?>