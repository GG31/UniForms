<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Form.class.php');
  require_once('../php/class/Element.class.php');
  
  class TestOfAnswer extends UnitTestCase {
	function testExample(){
		/***********************************
		It's not the unitary test, just a quick example of how to use the class form element.
		***************************************/
		//$form3 = new Form(3);
		//var_dump($form3->getFormElements());
		
		$e1 = new Element();
		$e1->setTypeElement(constant("typeInput"));
		$e1->setX(25);
		$e1->setY(12);
		$e1->setDefaultValue("default");
		$e1->setRequired(TRUE);
		$e1->setWidth(123);
		$e1->setHeight(23);
		//$e1->setPlaceholder("");
		//$e1->setDirection(0);
		//$e1->setIsbiglist(FALSE);
		///var_dump($e1);
		
		// It is not necessary to fill the properties that are not related to the element field type.
		
		$e2 = new Element();
		$e2->setTypeElement(constant("typeCheckbox"));
		$e2->setX(234);
		$e2->setY(15);
		//$e2->setDefaultValue("default");
		$e2->setRequired(FALSE);
		//$e2->setWidth(123);
		//$e2->setHeight(23);
		//$e1->setPlaceholder("");
		$e2->setDirection(1);
		$e2->setIsbiglist(TRUE);
		$options = array();
		$opt1 = array("value" => "secondoption", "order" => 2, "default" => true);
		$opt2 = array("value" => "thirdoption", "order" => 3, "default" => false);
		$opt3 = array("value" => "firstoption", "order" => 1, "default" => true);
		array_push($options, $opt1, $opt2, $opt3); //does not matter the order here...
		$e2->setOptions($options);
		//var_dump($e2);
		
		$form4 = new Form(4);
		$form4->setFormElements(array($e1, $e2)); //does not matter the order of the elements here...
		//var_dump($form4->getFormElements());
		$form4->save();
	}
  }
  

?>