<?php

require_once('simpletest/autorun.php');

include "include/translations.inc.php";

class TestTranslation extends UnitTestCase {

	 function testEnglish() {      
      $this->assertEqual(msg("ADDRESS"), "address");
	 }

	 function testEnglishUpperCase() {
      $this->assertEqual(ucfmsg("ADDRESS"), "Address");
	 }

	 function testArabic() {
      // $this->assertEqual(msg("ADDRESS"), "address");
	 }

	 function testArabicUpperCase() {
      // $this->assertEqual(ucfmsg("ADDRESS"), "Address");
	 }
}