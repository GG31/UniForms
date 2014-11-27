<?php
	include_once('class/DBSingleton.class.php');
	DBSingleton::getInstance();
	include_once("class/User.class.php");
	include_once("class/Form.class.php");

	//$_GET["form_id"]
	//$_GET["user_id"]
	//$_SESSION["crea_id"]

	$user = new User($_GET["crea_id"]); // TODO $_SESSION["user_id"]
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
	}
?>