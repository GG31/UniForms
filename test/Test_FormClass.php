<?php

  require_once('simpletest/autorun.php');
  require_once('/../php/include/connect.php');
  
  require_once('/../php/class/Form.class.php');
  require_once('/../php/class/User.class.php');
  require_once('/../php/class/Answer.class.php');

  class TestOfFormClass extends UnitTestCase {
  	
    function testConstruct1() {
	  $Form = new Form(1);
	  //Test Id
      $this->assertEqual($Form->getId(), 1);
      
      //Test Creator Simple
      $Creator = $Form->getCreator();
      $this->assertEqual($Creator->getId(), 1);
      $this->assertEqual($Creator->getName(), 'Luis');
      
      //Teste Creator(object)
      $user1 = new User(1); // Luis
      $this->assertEqual($Form->getCreator(), $user1);
      
      //Test State
      $this->assertFalse($Form->getstate());
      
      //Test printable
      $this->assertFalse($Form->getprintable());
      		
      //Test anonymous
      $this->assertFalse($Form->getanonymous());
      
      /*
      //Test Recepient
      $user2 = new User(2); // Romain
      $user3 = new User(3); // Genevieve
      $array = array($user1,  $user1, $user2, $user3);
      $this->assertIdentical($Form->getRecipient(), $array);
      */
    }
    
    function testConstruct2() {
    	$Form = new Form(-1);
    	$this->assertFalse($Form->getState());
    }
  }

  ?>