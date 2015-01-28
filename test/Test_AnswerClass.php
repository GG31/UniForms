<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Form.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/Element.class.php');
  require_once('../php/class/FormGroup.class.php');

class TestOfAnswerClass extends UnitTestCase {
	
	// State for new Answer
	function TestGetState1(){
		$newAnswer = new Answer();
		$this->assertTrue($newAnswer->getState() == FALSE);
    }
    
    /*
     * Select one formdest_id that has an answer for test
     * $rFormDest= mysql_fetch_array(mysql_query("SELECT * FROM formdest WHERE EXISTS(SELECT * FROM elementanswer WHERE elementanswer.formdest_id = formdest.formdest_id) LIMIT 1"));
     * $formDestId = $rFormDest["formdest_id"];
     * $qAnswers = mysql_query("SELECT * FROM elementanswer JOIN answervalue ON elementanswer.elementanswer_id = answervalue.elementanswer_id WHERE formdest_id = 1");
     */
    
    function TestGetAnswer() {
    	$existingAnswer = new Answer(2); //Answer of formdest_id = 1
    	$answerArray = (array(array("elementId" => 1, "value" => "10"), array("elementId" => 2, "value" => "1"), array("elementId" => 2, "value" => "2")));
    	$this->assertFalse($existingAnswer->getAnswers() == $answerArray);
    }
    
    function testGetId(){
    	$existingAnswer = new Answer(2); //Answer of formdest_id = 2
		$this->assertEqual($existingAnswer->getId(), 2);
    }
    
    function testGetFormId(){
    	$existingAnswer = new Answer(2); //Answer of formdest_id = 2
    	$this->assertEqual($existingAnswer->getFormId(), 3);
    }
    
    // State for an Answer already exist
    function testGetState2(){
    	$existingAnswer = new Answer(2); //Answer of formdest_id = 2
		$this->assertEqual($existingAnswer->getState(), TRUE);
    }
    
    function testGetRecipient(){
    	$existingAnswer = new Answer(2); //Answer of formdest_id = 2
		$this->assertEqual($existingAnswer->getRecipient(), new User(1));
    }
    
    // getAnswer for new Answer
    function TestSave_getAnswers1(){
    	$newAnswer = new Answer();
    	$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
    	
    	$newAnswer->setAnswers($answerArray);
    	$this->assertTrue($answerArray == $newAnswer->getAnswers());
    }
   
    function TestSave_getState1(){
    	$newAnswer = new Answer();
    	$newAnswer->setRecipient(new User(1));
    	$newAnswer->setFormId(3);
    	//$newAnswer->save();
    	//$this->assertEqual($newAnswer->getState(), FALSE);
    }
    /*
    // getAnswer for an Answer already exist
    function TestSave_getAnswers2(){
    	$newAnswer = new Answer();
    	$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));	
    	$newAnswer->setAnswers($answerArray);
    	$newAnswer->setRecipient(new User(1));
    	$newAnswer->setFormId(4);
    	$newAnswer->save();
    	$newFormId = $newAnswer->getId();
    	$newAnswer = new Answer($newFormId);
    	$this->assertTrue($newAnswer->getAnswers() == $answerArray);
    }
    
    
    function TestSave_getFormId(){
    	$newAnswer = new Answer();
    	$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
    	$newAnswer->setAnswers($answerArray);
    	$newAnswer->setRecipient(new User(1));
    	$newAnswer->setFormId(4);
    	$newAnswer->save();
    	$newFormId = $newAnswer->getId();
    	$newAnswer = new Answer($newFormId);
    	$this->assertEqual($newAnswer->getFormId(), 4);
    }
    
    function TestSave_getRecipient(){
    	$newAnswer = new Answer();
    	$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
    	$newAnswer->setAnswers($answerArray);
    	$newAnswer->setRecipient(new User(1));
    	$newAnswer->setFormId(4);
    	$newAnswer->save();
    	$newFormId = $newAnswer->getId();
    	$newAnswer = new Answer($newFormId);
    	$this->assertEqual($newAnswer->getRecipient(), new User(1));
    }
    
    // State for an Answer already exist after send
    function TestSave_send_getState2(){
    	$newAnswer = new Answer();
    	$answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
    	$newAnswer->setAnswers($answerArray);
    	$newAnswer->setRecipient(new User(1));
    	$newAnswer->setFormId(4);
    	$newAnswer->save();
    	$newFormId = $newAnswer->getId();
    	$newAnswer = new Answer($newFormId);
    	$newAnswer->send();
    	$this->assertEqual($newAnswer->getState(), TRUE);
    }
    
    function TestSave_deleteAnswer(){
	    $newAnswer = new Answer();
	    $answerArray = array(array("elementId" => 1, "value" => "15"), array("elementId" => 2, "value" => "0"), array("elementId" => 2, "value" => "56"), array("elementId" => 2, "value" => "29"));
	    $newAnswer->setAnswers($answerArray);
	    $newAnswer->setRecipient(new User(1));
	    $newAnswer->setFormId(4);
	    $newAnswer->save();
	    $newFormId = $newAnswer->getId();
	    $newAnswer = new Answer($newFormId);
	    $newAnswer->send();
	    $newAnswer->deleteAnswer();
	    $this->assertFalse(mysql_num_rows(mysql_query("SELECT * FROM formdest WHERE formdest_id = ".$newFormId)));
        $this->assertFalse(mysql_num_rows(mysql_query("SELECT * FROM elementanswer WHERE formdest_id = ".$newFormId)));  
    }*/
}
?>
