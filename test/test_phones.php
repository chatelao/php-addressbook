<?php

require_once('simpletest/autorun.php');

include "include/address.class.php";

class TestPhoneNumber extends UnitTestCase {

	 function testUnifyPhoneNumber() {	 	

	 	 $test_prefix = "+39";
	 	 
	 	 $addr[0]['home'] = "0385239233";
	 	 $addr[1]['home'] = "038 523 92 33";
	 	 $addr[2]['home'] = "038-523-92-33";
	 	 $addr[3]['home'] = "0039 38 523 92 33";
	 	 $addr[4]['home'] = "0039 38 523 92 33";
	 	 $addr[5]['home'] = "+39385239233";
	 	 $addr[6]['home'] = "+39 38 523 92 33";
	 	 $addr[7]['home'] = "+39 (0) 38 523 92 33";
	 	 $addr[8]['home'] = "+39 0 38 523 92 33";

	 	 for($i = 0; $i < count($addr); $i++) {
	 	   $address[] = new Address($addr[$i]);
	 	 }
	 	 
     //
     // The the unification of the phone numbers with extension
     //
	 	 for($i = 0; $i < count($addr); $i++) {
       $this->assertEqual( $addr[5]['home'], $address[$i]->unifyPhone($test_prefix)
                         , "Full unification '0' with: '".$i."' %s");
	 	 }                       
                       
     //
     // The the unification of the phone numbers without extension
     //
	 	 for($i = 0; $i < count($addr); $i++) {
       $this->assertEqual( $addr[0]['home']
                         , $address[$i]->unifyPhone($test_prefix, true)
                         , "Short unification '0' with: '".$i."' %s");
	 	 }

     //
     // The the shortification of the phone numbers
     //
	 	 for($i = 0; $i == 3; $i++) {
       $this->assertEqual( $addr[0]['home'], $address[$i]->shortPhone()
                         , "Short number '0' with: '".$i."' %s");
     }       
	 	 for($i = 4; $i == 8; $i++) {
       $this->assertEqual( $addr[4]['home'], $address[$i]->shortPhone()
                         , "Short number '3' with: '".$i."' %s");
     }       
	 }
}