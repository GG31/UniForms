<?php

  require_once('simpletest/autorun.php');
  require_once('../php/include/connect.php');
  
  require_once('../php/class/Form.class.php');
  require_once('../php/class/User.class.php');
  require_once('../php/class/Answer.class.php');
  require_once('../php/class/Element.class.php');
  require_once('../php/class/FormGroup.class.php');

  class TestOfFormClass extends UnitTestCase {
  	
  	function setUp(){
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
    
	
  }
?>