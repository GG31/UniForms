<?php

require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');
require_once('/../php/include/connect.php');

class TestOfIndex extends WebTestCase {
    
    function testHomepage() {
        $this->assertTrue($this->get('http://localhost/e-formulaire/UniForms/index.php'));
    }
}