<?php

require_once 'simpletest/autorun.php';
require_once 'simpletest/web_tester.php';

class TestReadWebpage extends WebTestCase {
		
		private $book_root_url;
		
    function setUp() {
		  $this->book_root_url = 
		     (    isset($_SERVER['HTTPS']) 
		      && strlen($_SERVER['HTTPS']) > 0 ? "https" : "http")
		    . "://"
		    . $_SERVER['SERVER_NAME']
			  . dirname($_SERVER['REQUEST_URI']);

			  $this->get( $this->book_root_url
			            . "/index.php" );
        $this->setField('user', 'simpletest');
        $this->setField('pass', 'simple');
        $this->click('Login');
    }

    function testLogin() {
        $this->assertCookie('uin');
    }

		function testHomepage() {
			
			$this->get( $this->book_root_url
			          . "/index.php" );

      // Check the english title
		  $this->assertTitle("Address book");

      // Search text in the end of the page
      $this->assertText('php-addressbook');
		}
		
		function testView() {
			$this->get( $this->book_root_url
			          . "/view.php" );
			$this->assertText('select a valid entry');
		}

		function testAdd() {
			$this->get( $this->book_root_url
			          . "/edit.php" );
			
			// Check for label
			$this->assertText('Address:');
			
			// Check for button
			$this->assertField('quickadd', 'Next');
		}

		function testExportCsv() {
			$this->get( $this->book_root_url
			          . "/csv.php?group=&submit=Download" );
			$this->assertHeader('Content-Type', 'application/vnd.ms-excel');
		}

		function testExportVCard() {
			$this->get( $this->book_root_url
			          . "/export.php?type=vCard-one&submit=Download" );
			$this->assertHeader('Content-Type', 'text/x-vcard');
		}
		
		function testZPush() {
			$this->get( $this->book_root_url
			          . "/z-push" );
      $this->assertResponse(401);
		  $this->assertAuthentication('Basic');
      $this->assertRealm('ZPush');
		}

		function testZPushLogin() {
			$this->get($this->book_root_url."/z-push");
        $this->authenticate('simpletest', 'simple');
        $this->assertText('GET not supported');
    }
}
?>