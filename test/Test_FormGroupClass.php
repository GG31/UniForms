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

	function testFormGroup(){
		
		$FormGroup = new FormGroup(-1);

		$e1 = new Element();
		$e1->setTypeElement(constant("typeInputText"));
		$e1->setX(25);
		$e1->setY(12);
		$e1->setDefaultValue("default");
		$e1->setLabel("label");
		$e1->setPlaceholder("placeholder");
		$e1->setRequired(TRUE);
		$e1->setWidth(123);
		$e1->setHeight(23);
		$e1->setMaxvalue("100");
		$e1->setMinvalue("1");
		
		$e2 = new Element();
		$e2->setTypeElement(constant("typeCheckbox"));
		$e2->setX(40);
		$e2->setY(15);
		$e2->setRequired(FALSE);
		$e2->setDirection(1);
		$e2->setIsbiglist(FALSE);
		$options = array();
		$opt1 = array("value" => "1", "order" => 2, "default" => false);
		$opt2 = array("value" => "2", "order" => 3, "default" => false);
		$opt3 = array("value" => "3", "order" => 1, "default" => true);
		array_push($options, $opt1, $opt2, $opt3); //does not matter the order here...
		$e2->setOptions($options);

		$u1 = new User(1);
		$u2 = new User(2);
	
		$FormGroup->setRecipient(array($u1, $u2));
		$this->assertEqual($FormGroup->getFormGroupRecipients()[0]["User"], $u1);
		$this->assertEqual($FormGroup->getFormGroupRecipients()[1]["User"], $u2);

		$FormGroup->setFormGroupElements(array($e1, $e2));
		$this->assertEqual($FormGroup->getGroupElements(), array($e1, $e2));
	
		$formId = 20;
		$FormGroup->save($formId);
	}	
  }
  
?>
