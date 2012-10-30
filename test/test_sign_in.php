<?php

require_once 'simpletest/autorun.php';
require_once 'simpletest/web_tester.php';

class TestSignIn extends WebTestCase {
	
/*
 * Phase 1:
 * - User: Create new
 * - Pass: Change 
 * - Pass: Remember
 *
 * Phase 2:
 * - User: Define admin/root
 * - User: Set permissions/block
 *
 */
	
	function testCreateNewLogin() {
			$this->assertText('GET not supported');
    }
}
?>