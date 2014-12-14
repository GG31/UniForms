<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Form.class.php');
  require_once('../php/class/Element.class.php');
  
  class TestOfElementClass extends UnitTestCase {
  	/*************************************************************************************
  	 It's not the unitary test, just a quick example of how to use the class form element.
  	*************************************************************************************/
  	
  	// Test for basic type "typeInput"
  	
  	function test_B_getTypeElement(){
  		$e1 = new Element();
  		$e1->setTypeElement(constant("typeInput"));
  		$this->assertEqual($e1->getTypeElement(), 1);
  	}
  	
  	function test_B_getX(){
  		$e1 = new Element();
  		$e1->setX(25);
  		$this->assertEqual($e1->getX(), 25);
  	}
  	
  	function test_B_getY(){
  		$e1 = new Element();
  		$e1->setY(12);
  		$this->assertEqual($e1->getY(), 12);
  	}
  	
  	function test_B_getDefaultValue(){
  		$e1 = new Element();
  		$e1->setDefaultValue("default");
  		$this->assertEqual($e1->getDefaultValue(), "default");	
  	}
  	
  	function test_B_getRequired(){
  		$e1 = new Element();
  		$e1->setRequired(TRUE);
  		$this->assertTrue($e1->getRequired());
  	}

  	function test_B_getWidth(){
  		$e1 = new Element();
  		$e1->setWidth(123);
  		$this->assertEqual($e1->getWidth(), 123);	
  	}
  	
  	function test_B_getHeight(){
  		$e1 = new Element();
  		$e1->setHeight(23);
  		$this->assertEqual($e1->getHeight(), 23);
  	}
  	
  	// It is not necessary to fill the properties that are not related to the element field type.
  	
  	// Test for advanced type "typeCheckbox"
  	
  	function test_A_getTypeElement(){
  		$e2 = new Element();
		$e2->setTypeElement(constant("typeCheckbox"));
  		$this->assertEqual($e2->getTypeElement(), 2);
  	}
  	
  	function test_A_getX(){
  		$e2 = new Element();
  		$e2->setX(25);
  		$this->assertEqual($e2->getX(), 25);
  	}
  	 
  	function test_A_getY(){
  		$e2 = new Element();
  		$e2->setY(12);
  		$this->assertEqual($e2->getY(), 12);
  	}
  	 
  	function test_A_getRequired(){
  		$e2 = new Element();
  		$e2->setRequired(TRUE);
  		$this->assertTrue($e2->getRequired());
  	}
  	
  	function test_A_getDirection(){
  		$e2 = new Element();
  		$e2->setDirection(1);
  		$this->assertEqual($e2->getDirection(), 1);
  	}
  	
  	function test_A_getIsbiglist(){
  		$e2 = new Element();
  		$e2->setIsbiglist(TRUE);
  		$this->assertTrue($e2->getIsbiglist());
  	}
  	
  	function test_A_getOptions(){
  		$e2 = new Element();		$options = array();
		$opt1 = array("value" => "secondoption", "order" => 2, "default" => true);
		$opt2 = array("value" => "thirdoption", "order" => 3, "default" => false);
		$opt3 = array("value" => "firstoption", "order" => 1, "default" => true);
		array_push($options, $opt1, $opt2, $opt3); //does not matter the order here...
		$e2->setOptions($options);
  		$this->assertEqual($e2->getOptions(), $options);
  	}

  	// Test for save element e1 and e2 in form4
  	function test_Save(){
		$e1 = new Element();
		$e1->setTypeElement(constant("typeInput"));
		$e1->setX(25);
		$e1->setY(12);
		$e1->setDefaultValue("default");
		$e1->setRequired(TRUE);
		$e1->setWidth(123);
		$e1->setHeight(23);
		
		$e2 = new Element();
		$e2->setTypeElement(constant("typeCheckbox"));
		$e2->setX(234);
		$e2->setY(15);
		$e2->setRequired(FALSE);
		$e2->setDirection(1);
		$e2->setIsbiglist(TRUE);
		$options = array();
		$opt1 = array("value" => "secondoption", "order" => 2, "default" => true);
		$opt2 = array("value" => "thirdoption", "order" => 3, "default" => false);
		$opt3 = array("value" => "firstoption", "order" => 1, "default" => true);
		array_push($options, $opt1, $opt2, $opt3); //does not matter the order here...
		$e2->setOptions($options);
		
  		$form4 = new Form(4);
		$form4->setFormElements(array($e1, $e2)); //does not matter the order of the elements here...
		$form4->save();
	}
  }
  

?>