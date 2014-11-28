<?php
//include_once ('include/includes.php');
require_once ("../include/connect.php");
require_once ("../include/verify_session.php");
include_once ("../class/User.class.php");
include_once ("../class/Form.class.php");

if (! empty ( $_POST )) {
   if(isset($_GET["id"])){
      $newForm = new Form($_GET['id']);
   }
   else {
      $newForm = new Form();
   }
   
   $newForm->setCreator(new User($_SESSION["user_id"]));
	if(!isset($_POST['printable'])){
		$newForm->setPrintable(0);
	}else{
		$newForm->setPrintable($_POST['printable']);
		$newForm->setRecipient("0");
	}
	if(!isset($_POST['Anonymat'])){
		$newForm->setAnonymous(0);
		$destinataires = array();
		foreach ($_POST as $key => $value) {
			$first = explode("_", $key);
			if ($first[0] == "checkboxDestinataire") {
				array_push($destinataires, new User($value));
			}
		$newForm->setRecipient($destinataires);		
		}
	}else{
		$newForm->setAnonymous($_POST['Anonymat']);
	}

	if (isset($_POST['enregistrer'])) {
	   //$newForm->save();
	   var_dump($newForm);
   }
   if (isset($_POST['valider'])) {
      //$newForm->send();
      var_dump($newForm);
   }
	//header ( "Location: ../home.php" );
}
?>
