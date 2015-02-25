<?php

  require_once('simpletest/autorun.php');
  require_once('/../php/include/connect.php');
  
  require_once('/../php/class/User.class.php');

  class TestOfUser extends UnitTestCase {
    function testId() {
	  $user = new User(1);
      $this->assertEqual($user->getId(), 1);
    }
  }

  ?>