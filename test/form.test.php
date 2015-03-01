<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Form.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Answer.class.php');
require_once('../php/class/Element.class.php');
require_once('../php/class/Group.class.php');
  
class TestOfFormClass extends UnitTestCase {
	
	// Test constructor and get functions
	function testConstruct(){
		global $database;
		// Insert data (creator, recipients, form, groups, formdest, elements and answers) to test construct and get functions
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); $idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver1')"); $idReceiver1 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver2')"); $idReceiver2 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',1,1,0)"); 
		$idForm = mysqli_insert_id($database);
		// Insert groups		
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 3)"); $idFormGroup1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 1)"); $idFormGroup2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 2)"); $idFormGroup3 = mysqli_insert_id($database);
		// Insert recipients
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver1.", ".$idFormGroup1.")"); $idFormDest1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver2.", ".$idFormGroup1.")"); $idFormDest2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver2.", ".$idFormGroup2.")"); $idFormDest3 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver1.", ".$idFormGroup3.")"); $idFormDest4 = mysqli_insert_id($database);
		// Insert elements
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup1.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup1.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup2.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement3 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup3.", ".constant("ELEMENT_DATE").", 'label', 10, 20)");
		$idElement4 = mysqli_insert_id($database);
		// Insert answers
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0,".$idFormDest1.",0)"); $idAnswer1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1,".$idFormDest1.",0)"); $idAnswer2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0,".$idFormDest3.",".$idAnswer1.")");$idAnswer3 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0,".$idFormDest4.",".$idAnswer3.")");$idAnswer4 = mysqli_insert_id($database);

		// Assertions
		$Form = New Form($idForm);
		$this->assertEqual($Form->id(), $idForm);
		$this->assertEqual($Form->creator(), new User($idCreator));
		$this->assertEqual($Form->name(), 'Name');
		$this->assertEqual($Form->state(), 1);	
		$this->assertEqual($Form->printable(), 1);	
		$this->assertEqual($Form->anon(), 0);
		$this->assertEqual($Form->groups(), [new Group($idFormGroup1), new Group($idFormGroup2), new Group($idFormGroup3)]);
		$this->assertEqual($Form->formdestId($idReceiver1, 0), $idFormDest1);
		$this->assertEqual($Form->formdestId($idReceiver2, 0), $idFormDest2);
		$this->assertEqual($Form->formdestId($idReceiver2, 1), $idFormDest3);
		$this->assertEqual($Form->formdestId($idReceiver1, 2), $idFormDest4);
		$this->assertEqual($Form->whichGroups($idReceiver1), [0, 2]);
		$this->assertEqual($Form->whichGroups($idReceiver2), [0, 1]);
		$this->assertEqual($Form->chain($idAnswer4), [$idCreator, $idReceiver1, $idReceiver2, $idReceiver1]);
		$this->assertEqual($Form->chain($idAnswer2), [$idCreator, $idReceiver1]);

		// remains to do the test of the tree function
		
		// Delete test data (if we delete users the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver2);
	}
	
	// Test save and set functions
	function testSave(){
		global $database;
		// Insert basic data
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); $idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver1')"); $idReceiver1 = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver2')"); $idReceiver2 = mysqli_insert_id($database); 
		// Create element and group objects 
		$Element1 = new Element();
		$Element1->type(constant("ELEMENT_NUMBER"));
		$Element1->x(50);
		$Element1->y(30);	
		$Element2 = new Element();
		$Element2->type(constant("ELEMENT_TEXT"));
		$Element2->x(20);
		$Element2->y(20);
		$Element3 = new Element();
		$Element3->type(constant("ELEMENT_TEXT"));
		$Element3->x(10);
		$Element3->y(10);
		$Group1 = new Group();
		$Group1->limit(2);
		$Group1->elements([$Element1, $Element2]);
		$Group1->users([new User($idReceiver1), new User($idReceiver2)]);
		$Group2 = new Group();
		$Group2->limit(3);
		$Group2->elements([$Element3]);
		$Group2->users([new User($idReceiver2)]);
		
		// Create object form
		$Form = new Form();
		$Form->creator(new User($idCreator));
		$Form->name("Form name");
		$Form->state(0);
		$Form->groups([$Group1, $Group2]);
		$Form->printable(0);
		$Form->anon(0);
		
		// Send: save and sets status to 1
		$Form->send();
		
		// Assertions
		$this->assertEqual($Form->creator(), new User($idCreator));
		$this->assertEqual($Form->name(), 'Form name');
		$this->assertEqual($Form->state(), 1);	
		$this->assertEqual($Form->printable(), 0);	
		$this->assertEqual($Form->anon(), 0);
		$this->assertEqual($Form->groups(), [$Group1, $Group2]);
		
		// Delete test data (if we delete users the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver2);
	}
}