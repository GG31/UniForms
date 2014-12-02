<?php
// Connect to database
// include("/../include/connect.php");
include_once ('DBSingleton.class.php');

// Include classes
include ("User.class.php");
include ("Form.class.php");
include ("Answer.class.php");
// Instancier la connection à la base de données
DBSingleton::getInstance ();

print_r ( $_POST );
?>