<?php

// Connect to database
//include("/../include/connect.php");
include_once('DBSingleton.class.php');

// Include classes
include("User.class.php");
include("Form.class.php");

// Instancier la connection à la base de données
$connect = DBSingleton::getInstance();
 
// Create object user (this user must already exists in the table users)
$oneUser = new User(1);
$oneUser -> getDestForms();

//echo "<br> User ID: ".$oneUser->userId;

// Creates a form with status "enregistrer"
$newForm = $oneUser->createForm();

$otherForm = new Form(4);

//$destList = array(3, 7, 2, 5);
//$otherForm->addDest($destList);

$resource = $otherForm->getAllFormReceivers(1);

if (mysql_num_rows($resource)){
	while($record = mysql_fetch_array($resource)){
		echo "<br> User ID: ".$record["user_id"]." - User name: ".$record["user_name"];
	}
}
?>