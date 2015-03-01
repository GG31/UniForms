<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Form.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Answer.class.php');
require_once('../php/class/Element.class.php');
require_once('../php/class/Group.class.php');
  
class TestOfGroupClass extends UnitTestCase {
  	
	// Test constructor and get functions
	function testConstruct(){
		global $database;
		// Inserts data (creator, recipients, form, formgroup, formdest, elements and answers) to test construct and get functions
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver1')"); 
		$idReceiver1 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver2')"); 
		$idReceiver2 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 2)");
		$idFormGroup = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver1.", ".$idFormGroup.")");
		$idFormDest1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver2.", ".$idFormGroup.")");
		$idFormDest2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0, " . $idFormDest1 . ", 0)");
		$idAnswer1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1, " . $idFormDest2 . ", 0)");
		$idAnswer2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1, " . $idFormDest2 . ", 0)");
		$idAnswer3 = mysqli_insert_id($database);
		
		// Assertions
		$Group = New Group($idFormGroup);
		$this->assertEqual($Group->id(), $idFormGroup);
		$this->assertEqual($Group->limit(), 2);
		$this->assertEqual($Group->elements(), [new Element($idElement1), new Element($idElement2)]);
		$this->assertEqual($Group->users(), [new User($idReceiver1), new User($idReceiver2)]);
		$this->assertEqual($Group->answers(), [$idReceiver1 => [new Answer($idAnswer1)], $idReceiver2 => [new Answer($idAnswer2), new Answer($idAnswer3)]]);
		$this->assertEqual($Group->validAnswers(), [$idReceiver1 => [], $idReceiver2 => [new Answer($idAnswer2), new Answer($idAnswer3)]]);
		$this->assertEqual($Group->formdestId($idReceiver1), $idFormDest1);
		$this->assertEqual($Group->formdestId($idReceiver2), $idFormDest2);
		
		// Delete test data (if we delete users the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver2);

	}	
	
	// Test save and set functions
	function testSave(){
		global $database;
		// Inserts basic data to be possible to insert a form group
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver1')"); 
		$idReceiver1 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver2')"); 
		$idReceiver2 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		
		$Element1 = new Element();
		$Element1->type(constant("ELEMENT_NUMBER"));
		$Element1->x(50);
		$Element1->y(30);
		
		$Element2 = new Element();
		$Element2->type(constant("ELEMENT_TEXT"));
		$Element2->x(20);
		$Element2->y(20);
		
		// Create object, set properties and save
		$Group = New Group();
		$Group->limit(3);
		$Group->elements([$Element1, $Element2]);
		$Group->users([new User($idReceiver1), new User($idReceiver2)]);
		$Group->save($idForm);
		
		// Assertions
		$this->assertEqual($Group->limit(), 3);
		$this->assertEqual($Group->elements(), [$Element1, $Element2]);
		$this->assertEqual($Group->users(), [new User($idReceiver1), new User($idReceiver2)]);
		
		// Delete test data (if we delete users the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver2);
	}
}  
?>