<?php
	include_once 'includes.php';
		
	if (isset($_POST["ans_id"])) {
		$ans = new Answer($_POST["ans_id"]);
	}

	if (isset($_POST["form_id"])) {
		$ans = new Answer();
		$ans->setFormId($_POST["form_id"]);
		$ans->setRecipient(new User($_SESSION["user_id"]));
	}

	if(isset($_POST["save"])){
		$ans->save();
	}
	if(isset($_POST["send"])){
		$ans->send();
	}

	header( "Location: ../home.php" );
?>