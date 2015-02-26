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
		global $database;
		// Inserts two users(creator and recipient), one form, one form group, two elements and one receiver to be possible to insert an answer into database
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver')"); 
		$idReceiver = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver.", ".$idFormGroup.")");
		$idFormDest = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysqli_insert_id($database);
		
		// Inserts an answer into table answer
		mysqli_query($database, "INSERT INTO answer(answer_status, formdest_id, answer_prev_id) VALUES (1, " . $idFormDest . ", 0)");
		$idAnswer = mysqli_insert_id($database);
		
		// Inserts the values of the answer into tables elementanswer and answervalue
		mysqli_query($database, "INSERT INTO elementanswer(formelement_id, answer_id) VALUES (".$idElement1." ,".$idAnswer.")");
		$idAnswerElem1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO elementanswer(formelement_id, answer_id) VALUES (".$idElement2." ,".$idAnswer.")");
		$idAnswerElem2 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO answervalue(value, elementanswer_id) VALUES('1'," . $idAnswerElem1 . ")");
		mysqli_query($database, "INSERT INTO answervalue(value, elementanswer_id) VALUES('2'," . $idAnswerElem1 . ")");
		mysqli_query($database, "INSERT INTO answervalue(value, elementanswer_id) VALUES('myanswer'," . $idAnswerElem2 . ")");
		
		// Test constructor and get functions
		$Answer = New Answer($idAnswer);
		$this->assertEqual($Answer->id(), $idAnswer);
		$this->assertEqual($Answer->prev(), 0);
		$this->assertEqual($Answer->state(), 1);
		$this->assertEqual($Answer->elementsValues(), [["elementId" => $idElement1, "values" => ["1", "2"]], ["elementId" => $idElement2, "values" => ["myanswer"]]]);
		$this->assertEqual($Answer->userId(), $idReceiver);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver);
	}
	
	// Test save and set functions
	function testSave(){
		global $database;
		// Inserts two users(creator and recipient), one form, one form group, two elements and one receiver to be possible to insert an answer into database
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Creator')"); 
		$idCreator = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO user(user_name) VALUES('Receiver')"); 
		$idReceiver = mysqli_insert_id($database); 
		mysqli_query($database, "INSERT INTO form(user_id, form_name, form_status, form_printable, form_anonymous) VALUES (".$idCreator.",'Name',0,1,0)"); 
		$idForm = mysqli_insert_id($database);	
		mysqli_query($database, "INSERT INTO formgroup(form_id, group_limit) VALUES(".$idForm.",1)");
		$idFormGroup = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formdest(user_id, formgroup_id) VALUES(".$idReceiver.", ".$idFormGroup.")");
		$idFormDest = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_MULTIPLE").", 'label', 10, 20)");
		$idElement1 = mysqli_insert_id($database);
		mysqli_query($database, "INSERT INTO formelement(formgroup_id, type_element, label, pos_x, pos_y) VALUES (".$idFormGroup.", ".constant("ELEMENT_TEXT").", 'label', 10, 20)");
		$idElement2 = mysqli_insert_id($database);
		
		// Creates new object answer and sets its properties
		$Answer = New Answer();
		$Answer->prev(0);
		$Answer->state(0);
		$arrayValues = [["elementId" => $idElement1, "values" => ["1", "2"]], ["elementId" => $idElement2, "values" => ["myanswer"]]];
		$Answer->elementsValues($arrayValues);
		
		// Send: save and sets status to 1
		$Answer->send($idFormDest);
		
		// Test if it was saved correctly in database
		$this->assertEqual($Answer->prev(), 0);
		$this->assertEqual($Answer->state(), 1);
		$this->assertEqual($Answer->elementsValues(), $arrayValues);
		$this->assertEqual($Answer->userId(), $idReceiver);
		$this->assertEqual($Answer->values($idElement1), ["1", "2"]);
		$this->assertEqual($Answer->values($idElement2), ["myanswer"]);
		
		// Delete test data (if we delete user the others are deleted by cascade)
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idCreator);
		mysqli_query($database, "DELETE FROM USER WHERE user_id = ".$idReceiver);
	}
}
?>