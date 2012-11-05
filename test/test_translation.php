<?php

require_once('simpletest/autorun.php');

include "include/translator.class.php";

class TestTranslation extends UnitTestCase {

   protected $trans;

   function setUp() {
     $this->trans = new QuestionTranslator();
     $this->trans = new GetTextTranslator();
   }

	 function testEnglishExplicit() {      
     $this->assertEqual($this->trans->msg("ADDRESS", "en"), "address");
	 }
	 
	 function testEnglishWithDefault() {      
     $this->assertEqual($this->trans->setDefaultLang("en"), "en");
     $this->assertEqual($this->trans->msg("ADDRESS"), "address");
	 }
	 
	 function testEnglishUpperCase() {
      $this->assertEqual($this->trans->ucfmsg("ADDRESS", "en"), "Address");
	 }

	 function testGerman() {
      $this->assertEqual($this->trans->setDefaultLang("de"), "de");
      $this->assertEqual($this->trans->msg("ADDRESS"), "Adresse");
	 }

	 function testArabicRightToLeft() {
      $this->assertEqual($this->trans->setDefaultLang("de"), "de");
      $this->assertEqual($this->trans->isRTL(), false);
      $this->assertEqual($this->trans->setDefaultLang("ar"), "ar");
      $this->assertEqual($this->trans->isRTL(), true);
	 }
	 
	 function testGetLang() {
      $this->assertEqual($this->trans->setDefaultLang("de"), "de");
      
      // Cannot set a non-accepted lang default
      $this->assertEqual($this->trans->setDefaultLang("xy"), "de");
      
      // Cannot get a non-accepted lang
      $this->assertEqual($this->trans->getLang("xy"), "de");
	 }

	 function testBestAcceptedLang() {
	    $accepted_languages = "de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4";	    
      $this->assertEqual($this->trans->getBestAcceptLang($accepted_languages), "de");
      $this->assertEqual($this->trans->getBestAcceptLang(""), "de");
   }	    
}