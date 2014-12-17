<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Form.class.php');
  require_once('../php/class/Element.class.php');
  
  class TestOfElementClass extends UnitTestCase {
  	
	function test_getTypeElement(){
  		$elem = new Element();
		$elem->setTypeElement(constant("typeCheckbox"));
  		$this->assertEqual($elem->getTypeElement(), constant("typeCheckbox"));
  	}  	
	
	function test_getX(){
  		$elem = new Element();
  		$elem->setX(25);
  		$this->assertEqual($elem->getX(), 25);
  	}
  	
  	function test_getY(){
  		$elem = new Element();
  		$elem->setY(12);
  		$this->assertEqual($elem->getY(), 12);
  	}
  	
  	function test_getDefaultValue(){
  		$elem = new Element();
  		$elem->setDefaultValue("default");
  		$this->assertEqual($elem->getDefaultValue(), "default");	
  	}
	
	function test_getRequired(){
  		$elem = new Element();
  		$elem->setRequired(TRUE);
  		$this->assertTrue($elem->getRequired());
  	}

  	function test_getWidth(){
  		$elem = new Element();
  		$elem->setWidth(123);
  		$this->assertEqual($elem->getWidth(), 123);	
  	}
  	
  	function test_getHeight(){
  		$elem = new Element();
  		$elem->setHeight(23);
  		$this->assertEqual($elem->getHeight(), 23);
  	}
	
	function test_getPlaceholder(){
  		$elem = new Element();
  		$elem->setPlaceholder("Placeholder");
  		$this->assertEqual($elem->getPlaceholder(), "Placeholder");
  	}
	
	function test_getDirection(){
  		$elem = new Element();
  		$elem->setDirection(1);
  		$this->assertEqual($elem->getDirection(), 1);
  	}
	
	function test_getIsbiglist(){
  		$elem = new Element();
  		$elem->setIsbiglist(TRUE);
  		$this->assertTrue($elem->getIsbiglist());
  	}
	
	function test_getMaxvalue(){
  		$elem = new Element();
  		$elem->setMaxvalue(15);
  		$this->assertEqual($elem->getMaxvalue(), 15);
  	}
	
	function test_getMinvalue(){
  		$elem = new Element();
  		$elem->setMinvalue(5);
  		$this->assertEqual($elem->getMinvalue(), 5);
  	}

	function test_getLabel(){
  		$elem = new Element();
  		$elem->setLabel("Name:");
  		$this->assertEqual($elem->getLabel(), "Name:");
  	}
  	
  	function test_getOptions(){
  		$elem = new Element();		$options = array();
		$opt1 = array("value" => "secondoption", "order" => 2, "default" => true);
		$opt2 = array("value" => "thirdoption", "order" => 3, "default" => false);
		$opt3 = array("value" => "firstoption", "order" => 1, "default" => true);
		array_push($options, $opt1, $opt2, $opt3); //does not matter the order here...
		$elem->setOptions($options);
  		$this->assertEqual($elem->getOptions(), $options);
  	}

  	// Test for save element e1 and e2 in form4
  	function test_Save(){
		
		// It is not necessary to fill the properties that are not related to the element field type.
		$e1 = new Element();
		$e1->setTypeElement(constant("typeInput"));
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