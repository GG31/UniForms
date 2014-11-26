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
$oneUser = new user(1);

//echo "<br> User ID: ".$oneUser->userId;

// Creates a form with status "enregistrer"
$newForm = $oneUser->enregistrerForm(1);

$DestList = array(3, 4, 6, 5);

$newForm->addDest($DestList);

$resource = $newForm->getAllFormsReceivers();

while($record = mysql_fetch_array($resource)){
	echo "<br> User ID: ".$record["user_id"]." - User name: ".$record["user_name"];
}
?>