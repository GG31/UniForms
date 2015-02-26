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
		// Insert data (creator, recipients, form, groups, formdest, elements and answers) to test construct and get functions
		mysql_query("INSERT INTO user(user_name) VALUES('Creator')"); $idCreator = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver1')"); $idReceiver1 = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver2')"); $idReceiver2 = mysql_insert_id(); 
		mysql_query("INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',1,1,0)"); 
		$idForm = mysql_insert_id();
		// Insert groups		
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 2)"); $idFormGroup1 = mysql_insert_id();
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.", 1)"); $idFormGroup2 = mysql_insert_id();
		// Insert recipients
		mysql_query("INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver1.", ".$idFormGroup1.")"); $idFormDest1 = mysql_insert_id();
		mysql_query("INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver2.", ".$idFormGroup1.")"); $idFormDest2 = mysql_insert_id();
		mysql_query("INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver2.", ".$idFormGroup2.")"); $idFormDest3 = mysql_insert_id();
		// Insert elements
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup1.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup1.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup2.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement3 = mysql_insert_id();
		// Insert answers
		mysql_query("INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0,".$idFormDest1.",0)"); $idAnswer1 = mysql_insert_id();
		mysql_query("INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1,".$idFormDest1.",0)"); $idAnswer2 = mysql_insert_id();
		mysql_query("INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (0,".$idFormDest3.",".$idAnswer1.")");$idAnswer3 = mysql_insert_id();
		
		// Assertions
		$Form = New Form($idForm);
		$this->assertEqual($Form->id(), $idForm);
		$this->assertEqual($Form->creator(), new User($idCreator));
		$this->assertEqual($Form->name(), 'Name');
		$this->assertEqual($Form->state(), 1);	
		$this->assertEqual($Form->printable(), 1);	
		$this->assertEqual($Form->anon(), 0);
		$this->assertEqual($Form->groups(), [new Group($idFormGroup1), new Group($idFormGroup2)]);
		
		// tree 
		// whichgroups
		// formdest
		// chain
		
		// Delete test data (if we delete users the others are deleted by cascade)
		mysql_query("DELETE FROM USER WHERE user_id = ".$idCreator);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver2);
	}
	
	// Test save and set functions
	function testSave(){
		// Insert basic data
		mysql_query("INSERT INTO user(user_name) VALUES('Creator')"); $idCreator = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver1')"); $idReceiver1 = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver2')"); $idReceiver2 = mysql_insert_id(); 
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
		mysql_query("DELETE FROM USER WHERE user_id = ".$idCreator);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver1);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver2);
	}
}