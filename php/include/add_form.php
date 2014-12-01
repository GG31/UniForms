<?php
	include_once 'includes.php';
	
	if (! empty ( $_POST )) {
		/*
			Getting a Form object
		 */
		if($_POST["form_id"] == -1){	// New form
			$form = new Form();

			// Creator is current user
			$form->setCreator(new User($_SESSION["user_id"]));

		}else{							// Already existing form
			$form = new Form($_POST['form_id']);
		}

		/*
			Form parameters
		 */
		$printable = FALSE;
		$anonymous = FALSE;
      $multifill = 1;
      
		if(isset($_POST["param"])){		// A checkbox is checked
			$printable = in_array("print", $_POST["param"]) ? TRUE : FALSE;
			$anonymous = in_array("anon", $_POST["param"]) ? TRUE : FALSE;
		}// Else : no param checked -> FALSE
		if(isset($_POST["parammulti"])) {
		   $multifill = $_POST["parammulti"];
		}

		$form->setPrintable($printable);
		$form->setAnonymous($anonymous);
		$form->setMultifill($multifill);
	
		/*
			Recipients
		 */
		$recipients = [];
		if($anonymous){					// Anonymous user (user_id == 0)
			$recipients[] = new User(0);
		}else{							// Listing USERs
			foreach ($_POST["recipient"] as $id) {
				$recipients[] = new User($id);
			}
		}
		
		$form->setRecipient($recipients);

		/*
			Actions
		 */
		if (isset($_POST['save'])) {
			$form->save();
		}
		if (isset($_POST['send'])) {
			$form->send();
		}
		header( "Location: ../home.php" );
	}
?>
