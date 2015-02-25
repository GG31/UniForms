<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Answer.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Form.class.php');
require_once('../php/class/Element.class.php');
require_once('../php/class/Group.class.php');
  
class TestOfElementClass extends UnitTestCase {
/*
  	function testSaveAndConstruct(){

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
		
  		/*$form4 = new Form(4);
		$form4->setFormElements(array($e1, $e2)); //does not matter the order of the elements here...
		$form4->save();*/
	/*}*/
	
	function testConstruct(){
		// Inserts one user, one form and one form group, to be possible to insert an element into the database
		mysql_query("INSERT INTO user(user_name) VALUES('User')"); 
		$idUser = mysql_insert_id(); 
		mysql_query("INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idUser.",'Name',0,1,0)"); 
		$idForm = mysql_insert_id();	
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysql_insert_id();
		
		// Inserts into formelement
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y, height, width, default_value, placeholder, min_value, max_value,
												required, isbiglist, direction, img)
							VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20, 15, 80, 'default', 'placeholder', 
										1, 10, 1, 0, ".constant("DIR_HORIZONTAL").", 'stringimg')");
		$idElement = mysql_insert_id();
		
		$Element = new Element($idElement);
		$this->assertEqual($Element->Type(), constant("ELEMENT_TEXT"));
		$this->assertEqual($Element->label(), "label");
		$this->assertEqual($Element->x(), 10);
		$this->assertEqual($Element->y(), 20);
		$this->assertEqual($Element->height(), 15);
		$this->assertEqual($Element->width(), 80);
		$this->assertEqual($Element->defaultValue(), "default");
		$this->assertEqual($Element->placeholder(), "placeholder");
		$this->assertEqual($Element->min(), 1);
		$this->assertEqual($Element->max(), 10);
		$this->assertTrue($Element->required());
		$this->assertFalse($Element->bigList());
		$this->assertEqual($Element->direction(), constant("DIR_HORIZONTAL"));
		$this->assertEqual($Element->img(), "stringimg");
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysql_query("DELETE FROM USER WHERE user_id = ".$idUser);
	}
	
	function testSave(){
		// Inserts one user, one form and one form group, to be possible to insert an element into the database
		mysql_query("INSERT INTO user(user_name) VALUES('User')"); 
		$idUser = mysql_insert_id(); 
		mysql_query("INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idUser.",'Name',0,1,0)"); 
		$idForm = mysql_insert_id();	
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysql_insert_id();
		
		// Creates new element and sets its properties, it's not necessary to fill properties which aren't related to element type.
		$newInputNumber = new Element();
		$newInputNumber->type(constant("ELEMENT_NUMBER"));
		$newInputNumber->x(50);
		$newInputNumber->y(30);
		$newInputNumber->defaultValue("50");
		$newInputNumber->label("number field");
		$newInputNumber->placeholder("placeholder");
		$newInputNumber->required(TRUE);
		$newInputNumber->width(123);
		$newInputNumber->height(23);
		$newInputNumber->max(30);
		$newInputNumber->min(0);
		
		// Save element
		$newInputNumber->save($idFormGroup);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysql_query("DELETE FROM USER WHERE user_id = ".$idUser);
	}
	
	/* All tests for gets and sets */
	
	function testType(){
  		$elem = new Element();
		$elem->type(constant("ELEMENT_TIME"));
  		$this->assertEqual($elem->type(), constant("ELEMENT_TIME"));
  	}
	
	function testX(){
  		$elem = new Element();
  		$elem->x(50);
  		$this->assertEqual($elem->x(), 50);
  	}
  	
  	function testY(){
  		$elem = new Element();
  		$elem->y(30);
  		$this->assertEqual($elem->y(), 30);
  	}
	
	function testDefault(){
  		$elem = new Element();
  		$elem->defaultValue("default");
  		$this->assertEqual($elem->defaultValue(), "default");	
  	}
	
	function testRequired(){
  		$elem = new Element();
  		$elem->required(TRUE);
  		$this->assertTrue($elem->required());
  	}

  	function testWidth(){
  		$elem = new Element();
  		$elem->width(150);
  		$this->assertEqual($elem->width(), 150);	
  	}
  	
  	function testHeight(){
  		$elem = new Element();
  		$elem->height(25);
  		$this->assertEqual($elem->height(), 25);
  	}
	
	function testPlaceholder(){
  		$elem = new Element();
  		$elem->placeholder("Placeholder");
  		$this->assertEqual($elem->placeholder(), "Placeholder");
  	}
	
	function testDirection(){
  		$elem = new Element();
  		$elem->direction(constant("DIR_VERTICAL"));
  		$this->assertEqual($elem->direction(), constant("DIR_VERTICAL"));
  	}
	
	function testBigList(){
  		$elem = new Element();
  		$elem->bigList(TRUE);
  		$this->assertTrue($elem->bigList());
  	}
	
	function testMaxvalue(){
  		$elem = new Element();
  		$elem->max(15);
  		$this->assertEqual($elem->max(), 15);
  	}
	
	function testMinvalue(){
  		$elem = new Element();
  		$elem->min(5);
  		$this->assertEqual($elem->min(), 5);
  	}
	
	function testLabel(){
  		$elem = new Element();
  		$elem->label("Name:");
  		$this->assertEqual($elem->label(), "Name:");
  	}
	
	function testImg(){
  		$elem = new Element();
  		$elem->img("stringwithencodedimage");
  		$this->assertEqual($elem->img(), "stringwithencodedimage");
  	}
}
?>