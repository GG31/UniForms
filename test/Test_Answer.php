<?php

  require_once('simpletest/autorun.php');
  require_once('/../php/include/connect.php');
  require_once('/../php/class/Answer.class.php');
  require_once('/../php/class/User.class.php');

class TestOfAnswer extends UnitTestCase {
	function testConstruct() {
		$newAnswer = new Answer();
		$this->assertTrue($newAnswer->getState() == FALSE);
		
		/*//Select one formdest_id that has an answer for test
		$rFormDest= mysql_fetch_array(mysql_query("SELECT * FROM formdest WHERE EXISTS(SELECT * FROM elementanswer WHERE elementanswer.formdest_id = formdest.formdest_id) LIMIT 1"));
		$formDestId = $rFormDest["formdest_id"];
		$qAnswers = mysql_query("SELECT * FROM elementanswer JOIN answervalue ON elementanswer.elementanswer_id = answervalue.elementanswer_id WHERE formdest_id = 1");*/
		
		$existingAnswer = new Answer(1); //Answer of formdest_id = 1
		$existingAnswer->getAnswers(); echo "<br>";
		$answerArray = (array(array("elementId" => 1, "value" => "10"), array("elementId" => 2, "value" => "1"), array("elementId" => 2, "value" => "2")));
		$this->assertTrue($existingAnswer->getAnswers() == $answerArray);
		$this->assertEqual($existingAnswer->getId(), 1);
		$this->assertEqual($existingAnswer->getFormId(), 4);
		$this->assertEqual($existingAnswer->getState(), FALSE);
		$this->assertEqual($existingAnswer->getRecipient(), new User(1));
    }
	
	function testSave(){
		$newAnswer = new Answer();
		$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
		
		$newAnswer->setAnswers($answerArray);
		$this->assertTrue($answerArray == $newAnswer->getAnswers());
		
		$newAnswer->setRecipient(new User(1));
		$newAnswer->setFormId(4);
		
		$newAnswer->save();
		$this->assertEqual($newAnswer->getState(), FALSE);
		$newFormId = $newAnswer->getId();
		
		$newAnswer = new Answer($newFormId);
		$this->assertTrue($newAnswer->getAnswers() == $answerArray);
		$this->assertEqual($newAnswer->getFormId(), 4);
		$this->assertEqual($newAnswer->getRecipient(), new User(1));
		
		$newAnswer->send();
		$this->assertEqual($newAnswer->getState(), TRUE);
	}
}
?>