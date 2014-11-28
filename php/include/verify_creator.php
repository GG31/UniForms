<?php
	include_once ('include/includes.php');

	/*
		ANSWERS.PHP
	 */
	$_SESSION["user_id"] = 1;
	$_GET["user_id"] = 4;
	$_GET["form_id"] = 1;

	function a(){
		return (new User($_SESSION["user_id"]))->isCreator($_GET["form_id"]);
	}

	function b(){
		$ans = (new Form($_GET["form_id"]))->getAnswer([$_GET["user_id"]], 1);
		return count($ans) > 0 ? TRUE : FALSE;
	}


	/*
		CREATEFORM.PHP
	 */
	function c(){
		return (new Form($_GET["form_id"]))->getState() == FALSE;
	}







	//$_GET["form_id"]
	//$_GET["user_id"]
	//$_SESSION["crea_id"]

	/*$user = new User($_GET["crea_id"]); // TODO $_SESSION["user_id"]
	$crea = $user->getCreatedForms();

	$ok = -1;

	while($line = mysql_fetch_array($crea)){
		if($line["form_id"] == $_GET["form_id"]){
			if($line["status"] == 1){
				//OK
				$ok = 1;
			}else{
				// To validate
				$ok = 0;
			}
			break;
		}
	}

	switch($ok){
		case -1:
			header ( "Location: NOT_YOUR_FORM.php" );
			break;
		case 0:
			header ( "Location: FORM_NOT_VALIDATED.php" );
			break;
	}*/
?>