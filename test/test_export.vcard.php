<?php

require_once('simpletest/autorun.php');

// Code
include "include/export.vcard.php";

class TestOfVCardExport extends UnitTestCase {
	
	 function testVCardAddress2LabelParsing() {
	 	
     // Data
     include "export.vcard/testdata_label2adr.php";
     
     foreach($tests as $test) {
     	 $expected = $test['output'];
     	 $result   = label2adr($test['input']);

     	 $diff = array_merge( array_diff($expected, $result)
     	                   , array_diff($result, $expected));
     
       // $this->assert($expected, $result, "gaga");
       $this->assertTrue(count($diff) == 0);
     }
   }
}
?>