<?php
  
  //
  // http://www.simpletest.org/en/start-testing.html
  //
  
  set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(dirname(__FILE__)))
                                      . PATH_SEPARATOR . dirname(dirname(__FILE__))
                                      . PATH_SEPARATOR . dirname(__FILE__));
                                      
require_once(dirname(__FILE__)."/simpletest/autorun.php");
require_once(dirname(__FILE__)."/simpletest/web_tester.php");
require_once(dirname(__FILE__)."/reporter_showing_passes.class.php");

class AllTests extends TestSuite {
	
    function AllTests() {
        $this->TestSuite('All tests');

        // end-to-end http-/html-tests
        $this->addFile('test_webpage.php');

        // class & function tests
        $this->addFile('test_translation.php');
        $this->addFile('test_export.vcard.php');
/*        
        $this->addFile('test_phones.php');
	      $this->addFile('test_birthday.php');
        $this->addFile('test_address_parse.php');
        $this->addFile('test_log.php');
        $this->addFile('test_import.vcard.php');
        $this->addFile('test_get.mainpages.php');
*/        
        // $this->run(new ReporterShowingPasses());
    }
}
?>