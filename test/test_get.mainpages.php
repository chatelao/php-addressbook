<?php
require_once('simpletest/web_tester.php');

class TestOfPageClicks extends WebTestCase {
    function testGetTheIndexPage() {
        $this->get("http://"."next2u.be/generic"."/index.php?lang=en");
        // $this->click('About');
        // $this->assertTitle('About why we are so great');
        // $this->assertText('We are really great');
        $this->assertTitle('Address book');
    }
}
?>
