<?php
  
  //
  // http://www.simpletest.org/en/start-testing.html
  //
  
  
  set_include_path(get_include_path() . PATH_SEPARATOR . "/home/apps/"
                                      . PATH_SEPARATOR . "/home/apps/books-git"
                                      . PATH_SEPARATOR . "/home/apps/books-git/test");
                                      
  require_once(dirname(__FILE__)."/simpletest/autorun.php");

class AllTests extends TestSuite {
	
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile('test_export.vcard.php');
        $this->addFile('test_translation.php');
/*        
        $this->addFile('test_phones.php');
	      $this->addFile('test_birthday.php');
        $this->addFile('test_address_parse.php');
        $this->addFile('test_log.php');
        $this->addFile('test_import.vcard.php');
        $this->addFile('test_get.mainpages.php');
*/        
    }
}
?>