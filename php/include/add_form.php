<?php
echo 'fuck you';
include_once ('include/includes.php');
echo 'fuck you';
if (! empty ( $_POST )) {
echo 'fuck you';
	$newForm = new Form();
echo 'fuck you';
	$destinataires = array();
	echo 'fuck you';
    foreach ($_POST as $key => $value) {
		$first = explode("_", $key);
		echo 'fuck you';
		if ($first[0] == "checkboxDestinataire") {
			array_push($destinataires, new User($value));
		}
    }
echo 'fuck you';
	$newForm->setCreator(new User($_SESSION["user_id"]));
	echo 'fuck you';
	$newForm->setRecipient($destinataires);
	echo 'fuck you';
	if (isset($_POST['enregistrer'])) {
	   $newForm->save();
   }
   if (isset($_POST['valider'])) {
      echo 'fuck you';
      $newForm->send();
      echo ' fuck';
   }
	header ( "Location: home.php" );
}
?>
