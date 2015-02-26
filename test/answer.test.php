<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Form.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/Element.class.php');
  require_once('../php/class/Group.class.php');

class TestOfAnswerClass extends UnitTestCase {
	
	// Test construct and get functions
	function testConstruct(){
		// Inserts two users(creator and recipient), one form, one form group, two elements and one receiver to be possible to insert an answer into database
		mysql_query("INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver')"); 
		$idReceiver = mysql_insert_id(); 
		mysql_query("INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysql_insert_id();	
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysql_insert_id();
		mysql_query("INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver.", ".$idFormGroup.")");
		$idFormDest = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysql_insert_id();
		
		// Inserts an answer into table answer
		mysql_query("INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1, " . $idFormDest . ", 0)");
		$idAnswer = mysql_insert_id();
		
		// Inserts the values of the answer into tables elementanswer and answervalue
		mysql_query("INSERT INTO elementanswer(formelement_id, answer_id) VALUES (".$idElement1." ,".$idAnswer.")");
		$idAnswerElem1 = mysql_insert_id();
		mysql_query("INSERT INTO elementanswer(formelement_id, answer_id) VALUES (".$idElement2." ,".$idAnswer.")");
		$idAnswerElem2 = mysql_insert_id();
		mysql_query("INSERT INTO answervalue(value, elementanswer_id) VALUES('1'," . $idAnswerElem1 . ")");
		mysql_query("INSERT INTO answervalue(value, elementanswer_id) VALUES('2'," . $idAnswerElem1 . ")");
		mysql_query("INSERT INTO answervalue(value, elementanswer_id) VALUES('myanswer'," . $idAnswerElem2 . ")");
		
		// Test constructor and get functions
		$Answer = New Answer($idAnswer);
		$this->assertEqual($Answer->id(), $idAnswer);
		$this->assertEqual($Answer->prev(), 0);
		$this->assertEqual($Answer->state(), 1);
		$this->assertEqual($Answer->elementsValues(), [["elementId" => $idElement1, "values" => ["1", "2"]], ["elementId" => $idElement2, "values" => ["myanswer"]]]);
		$this->assertEqual($Answer->userId(), $idReceiver);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysql_query("DELETE FROM USER WHERE user_id = ".$idCreator);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver);
	}
	
	// Test save and set functions
	function testSave(){
		// Inserts two users(creator and recipient), one form, one form group, two elements and one receiver to be possible to insert an answer into database
		mysql_query("INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysql_insert_id(); 
		mysql_query("INSERT INTO user(user_name) VALUES('Receiver')"); 
		$idReceiver = mysql_insert_id(); 
		mysql_query("INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysql_insert_id();	
		mysql_query("INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysql_insert_id();
		mysql_query("INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver.", ".$idFormGroup.")");
		$idFormDest = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysql_insert_id();
		mysql_query("INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysql_insert_id();
		
		// Creates new object answer and sets its properties
		$Answer = New Answer();
		$Answer->prev(0);
		$Answer->state(0);
		$arrayValues = [["elementId" => $idElement1, "values" => ["1", "2"]], ["elementId" => $idElement2, "values" => ["myanswer"]]];
		$Answer->elementsValues($arrayValues);
		
		// Save and sets status to 1
		$Answer->send($idFormDest);
		
		// Test if it was saved correctly in database
		$this->assertEqual($Answer->prev(), 0);
		$this->assertEqual($Answer->state(), 1);
		$this->assertEqual($Answer->elementsValues(), $arrayValues);
		$this->assertEqual($Answer->userId(), $idReceiver);
		$this->assertEqual($Answer->values($idElement1), ["1", "2"]);
		$this->assertEqual($Answer->values($idElement2), ["myanswer"]);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysql_query("DELETE FROM USER WHERE user_id = ".$idCreator);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idReceiver);
	}
}
?>