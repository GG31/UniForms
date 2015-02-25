<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Form.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Answer.class.php');
require_once('../php/class/Element.class.php');
require_once('../php/class/Group.class.php');

class TestOfUserClass extends UnitTestCase {

   function testUser(){
		mysql_query("INSERT INTO user(user_name) VALUES('User Test')");
		$idUser = mysql_insert_id(); 
		$user = new User($idUser);
		$this->assertEqual($user->name(), "User Test");
		$this->assertEqual($user->id(), $idUser);
		mysql_query("DELETE FROM USER WHERE user_id = ".$idUser);
   }
   
   // Test Created Forms
   
   // Test Forms to answer, answered forms
}

?>
