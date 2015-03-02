<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Answer.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Form.class.php');
require_once('../php/class/Element.class.php');
require_once('../php/class/Group.class.php');
  
class TestOfElementClass extends UnitTestCase {
	
	function testConstruct(){
		global $database;
		// Inserts one user, one form and one form group, to be possible to insert an element into the database
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('User')"); 
		$idUser = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idUser.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysqli_insert_id($database);
		
		// Inserts into formelement
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y, height, width, default_value, placeholder, min_value, max_value,
												required, isbiglist, direction, img)
							VALUES (".$idFormGroup.", ".constant("typeCheckbox").", 'label', 10, 20, 15, 80, 'default', 'placeholder', 
										1, 10, 1, 0, ".constant("DIR_HORIZONTAL").", 'stringimg')");
		$idElement = mysqli_insert_id($database);
		
		// Insert element options
		mysqli_query($database, "INSERT INTO elementoption(formelement_id, optionorder, optionvalue, optiondefault) VALUES (".$idElement.", 1, 'option 1', 0)");
		mysqli_query($database, "INSERT INTO elementoption(formelement_id, optionorder, optionvalue, optiondefault) VALUES (".$idElement.", 2, 'option 2', 0)");
		
		$Element = new Element($idElement);
		$this->assertEqual($Element->Type(), constant("typeCheckbox"));
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
		$this->assertEqual($Element->options(), [["order" => 1, "value" => "option 1" , "default" => 0], ["order" => 2, "value" => "option 2" , "default" => 0]]);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idUser);
	}
	
	function testSave(){
		global $database;
		// Inserts one user, one form and one form group, to be possible to insert an element into the database
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('User')"); 
		$idUser = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idUser.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysqli_insert_id($database);
		
		// Creates new element and sets its properties, it's not necessary to fill properties which aren't related to element type.
		$newInputNumber = new Element();
		$newInputNumber->type(constant("typeInputNumber"));
		$newInputNumber->x(50);
		$newInputNumber->y(30);
		$newInputNumber->defaultValue("50");
		$newInputNumber->label("number field");
		$newInputNumber->placeholder("placeholder");
		$newInputNumber->required(TRUE);
		$newInputNumber->width(200);
		$newInputNumber->height(20);
		$newInputNumber->max(30);
		$newInputNumber->min(0);
		
		// Creates new element and sets its properties, it's not necessary to fill properties which aren't related to element type.
		$newCheckbox = new Element();
		$newCheckbox->type(constant("typeCheckbox"));
		$newCheckbox->x(40);
		$newCheckbox->y(60);
		$newCheckbox->label("select multiple");
		$newCheckbox->direction(constant("DIR_VERTICAL"));
		$newCheckbox->bigList(TRUE);
		$arrayOpt = [["order" => 1, "value" => "first" , "default" => 0], ["order" => 2, "value" => "second" , "default" => 0]];
  		$newCheckbox->options($arrayOpt);
		
		// Save elements
		$newInputNumber->save($idFormGroup);
		$newCheckbox->save($idFormGroup);
		
		// Verifies if they were saved correctly
		$InputNumber = new Element($newInputNumber->id());
		$this->assertEqual($InputNumber->Type(), constant("typeInputNumber"));
		$this->assertEqual($InputNumber->label(), "number field");
		$this->assertEqual($InputNumber->x(), 50);
		$this->assertEqual($InputNumber->y(), 30);
		$this->assertEqual($InputNumber->height(), 20);
		$this->assertEqual($InputNumber->width(), 200);
		$this->assertEqual($InputNumber->defaultValue(), "50");
		$this->assertEqual($InputNumber->placeholder(), "placeholder");
		$this->assertEqual($InputNumber->min(), 0);
		$this->assertEqual($InputNumber->max(), 30);
		$this->assertTrue($InputNumber->required());
		
		$Checkbox = new Element($newCheckbox->id());
		$this->assertEqual($Checkbox->Type(), constant("typeCheckbox"));
		$this->assertEqual($Checkbox->label(), "select multiple");
		$this->assertEqual($Checkbox->x(), 40);
		$this->assertEqual($Checkbox->y(), 60);
		$this->assertTrue($Checkbox->bigList());
		$this->assertEqual($Checkbox->direction(), constant("DIR_VERTICAL"));
		$this->assertEqual($Checkbox->options(), $arrayOpt);
		
		// Delete test data (if we delete the user the related data is deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idUser);
	}
	
	/* All tests for gets and sets */
	
	function testType(){
  		$elem = new Element();
		$elem->type(constant("typeInputTime"));
  		$this->assertEqual($elem->type(), constant("typeInputTime"));
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
	
	function testOptions(){
  		$elem = new Element();
		$arrayOpt = [["order" => 1, "value" => "option 1" , "default" => 0], ["order" => 2, "value" => "option 2" , "default" => 1]];
  		$elem->options($arrayOpt);
  		$this->assertEqual($elem->options(), $arrayOpt);
  	}
}
?>