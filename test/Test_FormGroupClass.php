<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Form.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/Element.class.php');
  require_once('../php/class/FormGroup.class.php');
  
  class TestOfFormClass extends UnitTestCase {
  	 
  	function setUp(){
  		$FormGroup = new FormGroup();
  	}
  	
  	function tearDown() {
  		$FormGroup = null;
  	}
  	
  	function testConstruct1_ID() {
  		$FormGroup = new FormGroup(-1);
  		$this->assertEqual($FormGroup->getId(), NULL);
  	}
  	
  	function testSet_ID() {
  		$FormGroup = new FormGroup(-1);
  		$FormGroup->setId(1);
  		$this->assertEqual($FormGroup->getId(), 1);
  	}
  	
  	function getFormGroupRecipients(){
  		$FormGroup = new FormGroup(-1);
  		$list  = $this->getFormGroupRecipients(1, -1);
  		$user2 = new User(2); // Romain
  		$user3 = new User(3); // Genevieve
  		$this->assertEqual($list[0]["User"]->getName(), "Romain");
  		$this->assertEqual($list[1]["User"]->getName(), "Genevieve");
  	}
  
  }
  
?>