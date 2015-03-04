<?php
	include_once 'includes.php';
	
	if (isset($_POST["ans_id"])) {
		$ans = new Answer($_POST["ans_id"]);
	}

	if (isset($_POST["form_id"]) && isset($_POST["formdest_id"]) && isset($_POST["prev_id"])) {
		$ans = new Answer();
		$ans->prev($_POST["prev_id"]);
	}

	// echo "<pre>";
	// var_dump($_POST["answers"]);
	// echo "</pre>";
	$ans->elementsValues(json_decode($_POST["answers"],true));
	// echo "<pre>";
	// var_dump($ans->elementsValues());
	// echo "</pre>";
	// return;
	if(isset($_POST["save"])){
		$ans->save($_POST["formdest_id"]);
	}
	if(isset($_POST["send"])){
		$ans->send($_POST["formdest_id"]);
	}
	
	header( "Location: ../recipient.php" );
?>