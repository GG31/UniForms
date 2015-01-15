<?php

require_once('simpletest/autorun.php');
require_once('../php/include/connect.php');

require_once('../php/class/Form.class.php');
require_once('../php/class/User.class.php');
require_once('../php/class/Answer.class.php');
require_once('../php/class/Element.class.php');

class TestOfUserClass extends UnitTestCase {
   private $user;

   function setUp() {

   }

   function tearDown() {
      $user = null;
   }

   function testGetId()
   {
      $user = new User(1);
      $user_id = $user->getId();
      $this->assertEqual($user_id, 1);
   }

   function testGetName1()
   {
      $user = new User(1);
      $user_name = $user->getName();
      $this->assertEqual($user_name, "Luis");
   }

   function testGetName2() {
      $user = new User(0);
      $this->assertTrue($user->getName(), "Anonymous");
   }

   function testAll()
   {
      $users = User::all();
     
      $this->assertEqual(count($users), 4);
      $this->assertEqual($users[1]->getId(),2);
      $this->assertEqual($users[1]->getName(),"Romain");
   }

   function testGetCreatedForms()
   {
     $user = new User(1);
     $user_forms = $user->getCreatedForms();
     $this->assertEqual(count($user_forms), 5);
   }

   function testDestinatairesForms()
   {
      $user = new User(1);
      $user_forms = $user->getDestinatairesForms();
      $this->assertEqual(count($user_forms), 1);
   }

   function testIsCreator1() {
      $user = new User(1);
      $this->assertFalse($user->isCreator(-1));
   }

   function testIsCreator2() {
      $user = new User(1);
      $this->assertTrue($user->isCreator(1));
   }

   function testIsCreator3() {
      $user = new User(1);
      $this->assertFalse($user->isCreator(3));
   }

   function testIsDestinataire1() {
      $user = new User(1);
      $this->assertFalse($user->isDestinataire(-1));
   }

   function testIsDestinataire2() {
      $user = new User(1);
      $this->assertTrue($user->isDestinataire(4));
   }

   function testIsDestinataire3() {
      $user = new User(1);
      $this->assertFalse($user->isDestinataire(1));
   }

   function testIsAnonymous1() {
      $user = new User(1);
      $this->assertFalse($user->isAnonymous());
   }

   function testIsAnonymous2() {
      $user = new User(0);
      $this->assertTrue($user->isAnonymous());
   }   
}

?>
