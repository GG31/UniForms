<?php
include_once 'includes.php';
if (! empty ( $_POST )) {

   // echo "<pre>";
   // var_dump($_POST);
   // echo "</pre>";
	/*
	 * Getting a Form object
	 */
	if ($_POST ["form_id"] == -1) { // New form
		$form = new Form ();
		
		// Creator is current user
		$form->creator ( new User ( $_SESSION ["user_id"] ) );
	} else { // Already existing form
		$form = new Form ( $_POST ['form_id'] );
	}
	/*
	 * Form parameters
	 */
	$printable = FALSE;
	$anonymous = FALSE;
	
	if (isset ( $_POST ["param"] )) { // A checkbox is checked
      // echo "PARAM<br><pre>";
      // var_dump($_POST["param"]);
      // echo "</pre>";
		$printable = in_array ( "print", $_POST ["param"] ) ? TRUE : FALSE;
		$anonymous = in_array ( "anon", $_POST ["param"] ) ? TRUE : FALSE;
	} // Else : no param checked -> FALSE
   if (isset ( $_POST ["infoFormName"] )) {
      // echo "INFOFORMNAME:<br><pre>";
      // var_dump($_POST["infoFormName"]);
      // echo "</pre>";
      $formName = $_POST ["infoFormName"];
      $form->name($formName);
    }
	if (isset ( $_POST ["usersGroups"] )) {

      // echo "USERSGROUPS:<br><pre>";
      // var_dump($_POST["usersGroups"]);
      // echo "</pre>";
		$usersGroups = json_decode($_POST ["usersGroups"], true);
      // echo "USERSGROUPS (decoded) :<br><pre>";
      // var_dump($usersGroups);
      // echo "</pre>";
	}
	
	$form->printable ( $printable );
	$form->anon ( $anonymous );

   /*
   * Récupère les données des éléments
   */
   if(isset($_POST['info'])) {
       /*echo "INFO:<br><pre>";
       var_dump($_POST["info"]);
       echo "</pre>";*/


      $obj=json_decode($_POST['info'], true, 4);
      $arrayElements = [];


      foreach ($obj as $key => $array){
         $arrayElements[$key] = treatmentElement($key, $array);
      }


      // if(isset($_POST['infoGroups'])) {
      if($anonymous == FALSE) {
         // echo "INFOGROUPS:<br><pre>";
         // var_dump($_POST["infoGroups"]);
         // echo "</pre>";

         $formGroups = [];
         $obj=json_decode($_POST['infoGroups'], true, 4);

         foreach ($obj as $key => $array){
            $group1 = new Group();
            $listEl = [];
            $users = [];

            foreach ($usersGroups["group_" . $key] as $user) {
               $users[] = new User($user["id"]);
            }


            foreach ($array as $nb => $idEl) {
               $listEl[] = $arrayElements[$idEl];
               unset($arrayElements[$idEl]);
            }


            if (count($listEl) > 0 || $key == 0) {
               $group1->users($users);
               $group1->limit($_POST["group_" . $key . "_multiple"]);
               $group1->elements($listEl);
               $formGroups[] = $group1;
            }
         }

         $formGroups[0]->elements($arrayElements);
         $form->groups($formGroups);
      } else {
         $group = new Group();
         $group->users([new User(0)]); // Anonymous user
         $group->limit(0);
         $group->elements($arrayElements);
         $form->groups([$group]); // The argument here must be an array of all groups of this form
      }
   }
   
	/*
	 * Actions
	 */
	if (isset ( $_POST ['save'] )) {
		$form->save ();
	}
	if (isset ( $_POST ['send'] )) {
		$form->send ();
	}
   // return;
	header ( "Location: ../created.php" );
}

function treatmentElement($key, $array) {
   $keyPart = explode('_', $key);
   $e = "";

   if(strcmp($keyPart[0],"elem") == 0){
      $e = new Element((int)$keyPart[1]);
   } else {
      $e = new Element();
   }

   $attrs = [
      "type"   => constant('type'.$array['type']),
      "x"      => $array['posX'],
      "y"      => $array['posY'],
      "width"  => $array['width'],
      "height" => $array['height']
   ];

   if(array_key_exists("required", $array)) {
      $attrs['required'] = $array['required'];
   }
   if(array_key_exists("label", $array)) {
      $attrs['label'] = $array['label'];
   }
   if(array_key_exists("value", $array)) {
      $attrs['label'] = $array['value'];
   }
   if(array_key_exists("defaultValue", $array)) {
      $attrs['defaultValue'] = $array['defaultValue'];
   }
   if(array_key_exists("minvalue", $array)) {
      $attrs['min'] = $array['minvalue'];
   }
   if(array_key_exists("maxvalue", $array)) {
      $attrs['max'] = $array['maxvalue'];
   }
   if(array_key_exists("values", $array)) {
      $options = array();
      $order = 1;
      foreach ($array['values'] as $value){
         $opt = array("value" => $value, "order" => $order, "default" => false);
         $order = $order + 1;
         $options[] = $opt;
      }
      $attrs["options"] = $options;
   }
   if(array_key_exists("base64", $array)) {
		/*list($type, $data) = explode(';', $array['base64']);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		file_put_contents('../../res/elemimg/'.$array['img'], $data);*/
      $attrs["img"] = $array['base64'];
   }

   $e->attr($attrs);
   return $e;
}
?>
