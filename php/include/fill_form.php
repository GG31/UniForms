<?php
	include_once 'includes.php';
	
	// Class Answer {
	// 	private $id;
	// 	private $prev;
	// 	private $state;
	// 	private $elementsValues;
	
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
		$ans->send();
	}
	return;
	header( "Location: ../home.php" );
?>