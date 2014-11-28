<?php
//include_once ('includes.php');

if (! empty ( $_POST )) {
// 	$newForm = new Form();

// 	$destinataires = array();
//     foreach ($_POST as $key => $value) {
// 		$first = explode("_", $key);
// 		if ($first[0] == "checkboxDestinataire") {
// 			array_push($destinataires, new User($value));
// 		}
//     }

// 	$newForm->setCreator(new User($_SESSION["user_id"]));
// 	$newForm->setRecipient($destinataires);
// 	if (isset($_POST['enregistrer'])) {
// 	   $newForm->save();
//    }
//    if (isset($_POST['valider'])) {
//       $newForm->send();
//    }
echo "Contenu du _POST<br/>";
var_dump($_POST);
	//header ( "Location: home.php" );
}
?>
