<?php
//include_once ('include/includes.php');
require_once ("../include/connect.php");
require_once ("../include/verify_session.php");
include_once ("../class/User.class.php");
include_once ("../class/Form.class.php");

if (! empty ( $_POST )) {
	$destinataires = array();
    foreach ($_POST as $key => $value) {
		$first = explode("_", $key);

		if ($first[0] == "checkboxDestinataire") {
			array_push($destinataires, new User($value));
		}
    }
    var_dump($destinataires);
    $newForm = new Form();
	$newForm->setCreator(new User($_SESSION["user_id"]));

	$newForm->setRecipient($destinataires);

	if (isset($_POST['enregistrer'])) {
	   $newForm->save();
   }
   if (isset($_POST['valider'])) {
      $newForm->send();
   }
	header ( "Location: ../home.php" );
}
?>
