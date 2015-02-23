<?php
	include_once 'includes.php';

	if(!isset($_GET["form"]) && !isset($_GET["user"]))
		return;

	$formId = $_GET["form"];
	$userId = $_GET["user"];

	$user = new User($userId);
	$form = new Form($formId);

	// l($form);
	$form->algo();

	function l($obj){
		if(is_array($obj)){
			echo '<pre>';
			print_r($obj);
			echo '</pre>';
			return;
		}
		if(is_object($obj)){
			echo '<pre>';
			var_dump($obj);
			echo '</pre>';
			return;
		}
		echo $obj;
		return;
	}

?>