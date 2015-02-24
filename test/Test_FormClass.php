<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Form.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/Element.class.php');
  require_once('../php/class/Group.class.php');

  class TestOfFormClass extends UnitTestCase {
  	
  	/*function setUp(){
  		$Form = new Form(1);
  	}
  	
  	
  	function tearDown() {
  		$Form = null;
  	}
    
    function testConstruct1_ID() {
      $Form = new Form(1);
      $this->assertEqual($Form->getId(), 1);
    }
    
    function testConstruct1_CreatorSimple() {
      //Test Creator Simple
      $Form = new Form(1);
      $Creator = $Form->getCreator();
      $this->assertEqual($Creator->getId(), 1);
      $this->assertEqual($Creator->getName(), 'Luis');
    }

    function testConstruct1_CreatorObjet() {
      //Teste Creator(object)
      $Form = new Form(1);
      $user1 = new User(1); // Luis
      $this->assertEqual($Form->getCreator(), $user1);
    }

    function testConstruct1_State() {
      //Test State
      $Form = new Form(1);
      $this->assertTrue($Form->getstate());
    }
    
    function testConstruct1_Printable() {
      //Test printable
      $Form = new Form(1);
      $this->assertFalse($Form->getprintable());
    }

    function testConstruct1_Anonymous() {
      //Test anonymous
      $Form = new Form(1);
      $this->assertFalse($Form->getanonymous());
    } 
    
    function testConstruct1_listRecipient(){
      //Test ListRecepient
      $Form = new Form(1);
      $user2 = new User(2); // Romain
      $user3 = new User(3); // Genevieve
      $list  = $Form->getFormRecipients([], 1);
      $this->assertEqual($list[0]["User"]->getName(), "Romain");
      $this->assertEqual($list[1]["User"]->getName(), "Genevieve");
    }
  
    function testConstruct2_ID() {
      $Form2 = new Form(-1);
      $this->assertNull($Form2->getId());
      
    }
    
    function testConstruct2_State() {
    	$Form2 = new Form(-1);
    	$this->assertFalse($Form2->getState());
    }
    
	function testSave(){
		// Creates a form with two groups
		$form = new Form();
		$form->setMaxAnswers(3);
		$form->setAnonymous(FALSE);
		$form->setPrintable(TRUE);
		$form->setName('name');
		$form->setCreator(new User(1));
			
		// Creates the first group, it will have 2 elements and 2 users
		$FormGroup1 = new FormGroup();
		
		// Creates the first element of the first group
		$e1 = new Element();
		$e1->setTypeElement(constant("typeInputText"));
		$e1->setX(50);
		$e1->setY(55);
		$e1->setLabel("label");
		$e1->setRequired(TRUE);
		$e1->setWidth(100);
		$e1->setHeight(20);
		
		// Creates the second element of the first group
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
		
		// Creates the 2 users of the first group 
		$u1 = new User(2);
		$u2 = new User(3);
		
		// Assigns the elements and users created above to a group
		$FormGroup1->setRecipient(array($u1, $u2));
		$FormGroup1->setFormGroupElements(array($e1, $e2));
		
		// Creates the second group
		$FormGroup2 = new FormGroup();
		
		// Creates the element of the second group
		$e3 = new Element();
		$e3->setTypeElement(constant("typeInputNumber"));
		$e3->setX(50);
		$e3->setY(55);
		$e3->setLabel("label");
		$e3->setWidth(100);
		$e3->setHeight(20);
		$e3->setMaxvalue("100");
		$e3->setMinvalue("1");
		
		// User of the second group
		$u3 = new User(4);
		
		// Assigns the element and the user created above to other group
		$FormGroup2->setRecipient(array($u3));
		$FormGroup2->setFormGroupElements(array($e3));
		
		// Sets the groups of the form
		$form->setGroups(array($FormGroup1, $FormGroup2));

		$form->save();
		
		// The functions getFormElements and getFormRecipients get data of the entire form, for get data of one group use the functions of FormGroup.Class
		$this->assertEqual($form->getFormElements(), array($e1, $e2, $e3));
		$this->assertEqual($form->getFormRecipients()[0]["User"], $u1);
		$this->assertEqual($form->getFormRecipients()[1]["User"], $u2);
		$this->assertEqual($form->getFormRecipients()[2]["User"], $u3);
	}	
	
	function testExport() {
    	$Form = new Form(1);
    	echo $Form->exportSQL();
    }*/
	
	function testGetAnswer() {
    	$Form = new Form(1);
    	$result = $Form->getAnswerableFormGroups(1);
		var_dump($result);
    }
  }
?>
