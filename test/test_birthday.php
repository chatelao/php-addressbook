<?php

require_once 'simpletest/autorun.php';
require_once "include/birthday.class.php";


class TestBirthday extends UnitTestCase {
	
		function testInitDate() {
			
      //
      // Birthday from UNIX-timestamp
      //
			$birthday = new Birthday(mktime(0,0,0,7,5,2007));
			$this->assertEqual($birthday->toDate(), mktime(0,0,0,7,5,2007));

      //
      // Birthday from array
      //
      $addr = array();
      $addr['bday']   =      5;
      $addr['bmonth'] = "July";
      $addr['byear']  =   2007;
			$birthday = new Birthday($addr, "b");
			$this->assertEqual($birthday->toDate(), mktime(0,0,0,7,5,2007));

			$birthday = new Birthday($addr, "a");
			$this->assertEqual($birthday->toDate(), false);

			$birthday = new Birthday($addr, "");
			$this->assertEqual($birthday->toDate(), false);

      $addr = array();
      $addr['aday']   =      5;
      $addr['amonth'] = "July";
      $addr['ayear']  =   2007;
			$birthday = new Birthday($addr, "a");
			$this->assertEqual($birthday->toDate(), mktime(0,0,0,7,5,2007));

      //
      // Birthday from single values
      //
			$birthday = new Birthday("5", "July", "2007");
			$this->assertEqual($birthday->toDate(), mktime(0,0,0,7,5,2007));

      //
      // Birthday from date format (vCard)
      //
			$birthday = new Birthday("2007-07-05");
			$this->assertEqual($birthday->toDate(), mktime(0,0,0,7,5,2007));
			
		}


		function testGetArray() {

			$birthday = new Birthday("5", "July", "2007");			
			$addr = $birthday->addToAddr(array("trans" => "it"));
			
			$this->assertEqual($addr['day'], "     5");
			$this->assertEqual($addr['month'], "July");
			$this->assertEqual($addr['year'],  "2007");
			$this->assertEqual($addr['trans'],   "it");
			

			$addr = $birthday->setPrefix("b")->addToAddr(array());
			
			$this->assertEqual($addr['bday'], "     5");
			$this->assertEqual($addr['bmonth'], "July");
			$this->assertEqual($addr['byear'],  "2007");
			
    }			
    
		function testGetAge() {		
			
			$birthday = new Birthday("5", "July", "2007");
      $birthday->today = mktime(0,0,0,1,29,2011);
			$this->assertEqual($birthday->getAge(), 3);
			
      $birthday->today = mktime(0,0,0,7,4,2011);
			$this->assertEqual($birthday->getAge(), 3);

      $birthday->today = mktime(0,0,0,7,5,2011);
			$this->assertEqual($birthday->getAge(), 4);

      $birthday->today = mktime(0,0,0,7,6,2011);
			$this->assertEqual($birthday->getAge(), 4);

      $birthday->today = mktime(0,0,0,8,28,2011);
			$this->assertEqual($birthday->getAge(), 4);

      $birthday->today = mktime(0,0,0,1,1,2012);
			$this->assertEqual($birthday->getAge(), 4);

      //
      // Without year = -1
      //
			$birthday = new Birthday("1", "July", "");
			$this->assertTrue($birthday->getAge() == -1);
    }
}

?>