<?php
	include_once 'includes.php';
	
	if (isset($_POST["ans_id"])) {
		$ans = new Answer($_POST["ans_id"]);
	}

	if (isset($_POST["form_id"]) && isset($_POST["formdest_id"]) && isset($_POST["prev_id"])) {
		$ans = new Answer();
		$ans->prev($_POST["prev_id"]);
	}

	$ans->elementsValues(json_decode($_POST["answers"],true));

	if(isset($_POST["save"])){
		$ans->save($_POST["formdest_id"]);
	}
	if(isset($_POST["send"])){
		$ans->send($_POST["formdest_id"]);
	}

	header( "Location: ../home.php" );
?>