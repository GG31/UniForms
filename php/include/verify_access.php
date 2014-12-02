<?php
/*
 * Triggers verification
 */
// var_dump($_SESSION["user_id"]);echo "<br>";
switch (explode ( '.', basename ( $_SERVER ["REQUEST_URI"] ), 2 )[0]) {
	case 'answers' :
		verify_access_answers ();
		break;
	case 'createform' :
		verify_access_create ();
		break;
	case 'fillform' :
		verify_access_fill ();
		break;
}

/*
 * ANSWERS.PHP:
 * $_GET["form_id"]:
 * $_SESSION["user_id"] is creator of $_GET["form_id"]
 * $_GET["form_id"] AND $_GET["user_id"]:
 * $_SESSION["user_id"] is creator of $_GET["form_id"]
 * $_GET["form_id"] answered by $_GET["user_id"]
 */
function verify_access_answers() {
	$b1 = FALSE;
	$b2 = TRUE;
	
	if (isset ( $_GET ["form_id"] )) {
		$b1 = (new User ( $_SESSION ["user_id"] ))->isCreator ( $_GET ["form_id"] );
		$b1 ? TRUE : header ( "Location: error.php?e=1" );
		
		if (isset ( $_GET ["user_id"] )) {
			$ans = (new Form ( $_GET ["form_id"] ))->getAnswer ( [ 
					$_GET ["user_id"] 
			], 1 );
			$b2 = count ( $ans ) == 1 ? TRUE : FALSE;
			$b2 ? TRUE : header ( "Location: ../error.php?e=2" );
		}
	}
}

/*
 * CREATEFORM.PHP:
 * $_GET["form_id"]:
 * $_SESSION["user_id"] is creator of $_GET["form_id"]
 * void:
 * ok
 */
function verify_access_create() {
	$b = TRUE;
	
	if (isset ( $_GET ["form_id"] )) {
		$b = (new User ( $_SESSION ["user_id"] ))->isCreator ( $_GET ["form_id"] );
		$b ? TRUE : header ( "Location: error.php?e=3" );
	}
}

	/*
		FILLFORM.PHP: TODO
			$_GET["ans_id"]:
				form is validated (creation)
				$_SESSION["user_id"] is dest of form

	 */
	function verify_access_fill(){
		$b1 = FALSE;
		$b2 = FALSE;

		$ans = new Answer($_GET["ans_id"]);

		if($ans->getRecipient()->isAnonymous())// Access granted for anonymous form
			return;

		$f 	 = new Form($ans->getFormId());
		
		$b1  = $f->getState() == TRUE;
		$b1 ? TRUE : header("Location: error.php?e=4" );
		if($f->getAnonymous()){// Access granted for anonymous form
		   //Créer une answer
		   $form->createAnswer(0);
		   //header("Location: fillform.php?ans_id=4" );
	   }


		if($b1){
			$b2  = $ans->getRecipient()->getId() == $_SESSION["user_id"];
			$b2 ? TRUE : header("Location: error.php?e=5" );
		}
	}

?>
