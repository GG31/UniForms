<?php
include_once 'includes.php';
if (! empty ( $_POST )) {   
   // var_dump($_POST ["info"]);
	/*
	 * Getting a Form object
	 */
	if ($_POST ["form_id"] == - 1) { // New form
		$form = new Form ();
		
		// Creator is current user
		$form->setCreator ( new User ( $_SESSION ["user_id"] ) );
	} else { // Already existing form
		$form = new Form ( $_POST ['form_id'] );
	}
	/*
	 * Form parameters
	 */
	$printable = FALSE;
	$anonymous = FALSE;
	$multifill = 1;
	
	if (isset ( $_POST ["param"] )) { // A checkbox is checked
		$printable = in_array ( "print", $_POST ["param"] ) ? TRUE : FALSE;
		$anonymous = in_array ( "anon", $_POST ["param"] ) ? TRUE : FALSE;
	} // Else : no param checked -> FALSE
	if (isset ( $_POST ["parammulti"] )) {
		$multifill = $_POST ["parammulti"];
	}
	if (isset ( $_POST ["infoFormName"] )) {
	   // echo "hhh";
		$formName = $_POST ["infoFormName"];
		// echo $formName;
	   $form->setName($formName);
	}
	
	$form->setPrintable ( $printable );
	$form->setAnonymous ( $anonymous );
	$form->setMaxAnswers ( $multifill );
	
	/*
	 * Recipients
	 */
	$recipients = [ ];
	if ($anonymous) { // Anonymous user (user_id == 0)
		$recipients [] = new User ( 0 );
	} else { // Listing USERs
		foreach ( $_POST ["recipient"] as $id ) {
			$recipients [] = new User ( $id );
		}
	}
	$form->setRecipient ( $recipients );
	// echo "lol<br>";
	/*
    * Récupère les données des éléments
    */
   if(isset($_POST['info'])) { 
      $obj=json_decode($_POST['info'], true, 4);
      $arrayElements = [];
      foreach ($obj as $key => $array){
         // var_dump($array);
         // echo "<br>";
         $arrayElements[] = treatmentElement($key, $array);
      }
   }
   $form->setFormElements($arrayElements);
	/*
	 * Actions
	 */
	if (isset ( $_POST ['save'] )) {
		$form->save ();
	}
	if (isset ( $_POST ['send'] )) {
		$form->send ();
	}

	header ( "Location: ../home.php" );
}

function treatmentElement($key, $array) {
   $keyPart = explode('_', $key);
   // echo "explode ".$keyPart[0]." ".$key."<br>";

   $e = "";
   if(strcmp($keyPart[0],"elem") == 0){
      // echo "strcmp <br>";
      $e = new Element((int)$keyPart[1]);
      // echo "post element<br>";
   } else {
      // echo "child<br>";
      $e = new Element();
   }

   // echo "type ".$array['type'];
   $e->setTypeElement(constant('type'.$array['type']));
   $e->setX($array['posX']);
   $e->setY($array['posY']);
   if(array_key_exists("required", $array)) {
      $e->setRequired($array['required']);
   }
   if(array_key_exists("label", $array)) {
      $e->setLabel($array['label']);
   }
   if(array_key_exists("defaultValue", $array)) {
      $e->setDefaultValue($array['defaultValue']);
   }
   if(array_key_exists("min", $array)) {
      $e->setMinvalue($array['min']);
   }
   if(array_key_exists("max", $array)) {
      $e->setMaxvalue($array['max']);
   }
   if(array_key_exists("values", $array)) {
      $options = array();
      $order = 1;
      foreach ($array['values'] as $value){
         $opt = array("value" => $value, "order" => $order, "default" => false);
         $order = $order + 1;
         $options[] = $opt;
      }
		$e->setOptions($options);
   }
   return $e;
}
?>
