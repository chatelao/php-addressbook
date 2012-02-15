<?php
  
  //
  // http://www.simpletest.org/en/start-testing.html
  //
  
  
  set_include_path(get_include_path() . PATH_SEPARATOR . "/home/users/n/next2u/www/"
                                      . PATH_SEPARATOR . "/home/users/n/next2u/www/generic"
                                      . PATH_SEPARATOR . "/home/users/n/next2u/www/generic/test");
                                      
  require_once("simpletest/autorun.php");

class AllTests extends TestSuite {
	
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile('test_export.vcard.php');
        $this->addFile('test_phones.php');
        $this->addFile('test_birthday.php');
        $this->addFile('test_address_parse.php');
/*        
        $this->addFile('test_log.php');
        $this->addFile('test_import.vcard.php');
        $this->addFile('test_get.mainpages.php');
*/        
    }
}
?>