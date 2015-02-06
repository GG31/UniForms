<?php
include_once 'includes.php';
if (! empty ( $_POST )) {
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
		$formName = $_POST ["infoFormName"];
	   $form->setName($formName);
	}
	
	$form->setPrintable ( $printable );
	$form->setAnonymous ( $anonymous );
	$form->setMaxAnswers ( $multifill );
	
		// It must create the groups and set the recipients and elements for each group.
			$formGroup = new FormGroup();
	
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
			$formGroup->setRecipient ( $recipients );
			/*
			* Récupère les données des éléments
			*/
		   if(isset($_POST['info'])) { 
			  $obj=json_decode($_POST['info'], true, 4);
			  $arrayElements = [];
			  var_dump($obj);
			  foreach ($obj as $key => $array){
				 $arrayElements[] = treatmentElement($key, $array);
			  }
		   }
		   $formGroup->setFormGroupElements($arrayElements);
		   
		$form->setGroups(array($formGroup)); // The argument here must be an array of all groups of this form
		
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
   $e = "";
   if(strcmp($keyPart[0],"elem") == 0){
      $e = new Element((int)$keyPart[1]);
   } else {
      $e = new Element();
   }

   $e->setTypeElement(constant('type'.$array['type']));
   $e->setX($array['posX']);
   $e->setY($array['posY']);
   $e->setWidth($array['width']);
   $e->setHeight($array['height']);
   if(array_key_exists("required", $array)) {
      $e->setRequired($array['required']);
   }
   if(array_key_exists("label", $array)) {
      $e->setLabel($array['label']);
   }
   if(array_key_exists("defaultValue", $array)) {
      $e->setDefaultValue($array['defaultValue']);
   }
   if(array_key_exists("minvalue", $array)) {
      $e->setMinvalue($array['minvalue']);
   }
   if(array_key_exists("maxvalue", $array)) {
      $e->setMaxvalue($array['maxvalue']);
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
