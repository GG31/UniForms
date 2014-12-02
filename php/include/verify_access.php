<?php
	/*
		Triggers verification
	 */
	switch (explode('.', basename($_SERVER["REQUEST_URI"]), 2)[0]) {
		case 'answers':
			verify_access_answers();
			break;
		case 'createform':
			verify_access_create();
			break;
		case 'fillform':
			verify_access_fill();
			break;
	}

	/*
		ANSWERS.PHP:
			$_GET["form_id"]:
				$_SESSION["user_id"] is creator of $_GET["form_id"]
			$_GET["form_id"] AND $_GET["user_id"]:
				$_SESSION["user_id"] is creator of $_GET["form_id"]
				$_GET["form_id"] answered by $_GET["user_id"]
	 */
	function verify_access_answers() {
		$b1 = FALSE;
		$b2 = TRUE;
		
		if (isset ( $_GET ["form_id"] )) {
			$b1 = (new User ( $_SESSION ["user_id"] ))->isCreator ( $_GET ["form_id"] );
			$b1 ? TRUE : header ( "Location: error.php?e=1" );
			
			if (isset ( $_GET ["user_id"] )) {
				$ans = (new Form ( $_GET ["form_id"] ))->getListRecipient ( [ 
															$_GET ["user_id"] 
														], 1 );
				$b2 = count ( $ans ) == 1 ? TRUE : FALSE;// ? TODO
				$b2 ? TRUE : header ( "Location: error.php?e=2" );
			}
		}
	}

	/*
	 * CREATEFORM.PHP:
	 * 		$_GET["form_id"]:
	 *   		$_SESSION["user_id"] is creator of $_GET["form_id"]
	 *     void:
	 *     		ok
	 */
	function verify_access_create() {
		$b = TRUE;
		
		if (isset ( $_GET ["form_id"] )) {
			$b = (new User ( $_SESSION ["user_id"] ))->isCreator ( $_GET ["form_id"] );
			$b ? TRUE : header ( "Location: error.php?e=3" );
		}
	}

	/*
		FILLFORM.PHP: (Anonymous are allowed if form is anonymous)
			$_GET["form_id"]:
				form is validated (creation) & user is dest of form
				answer limit not reached
			$_GET["ans_id"]:
				form is validated (creation) & user is dest of form
	 */
	function verify_access_fill(){
		$b1 = FALSE;
		$b2 = FALSE;

		if(isset($_GET["form_id"])){
			$form_id = $_GET["form_id"];
		}
		if(isset($_GET["ans_id"])){
			$ans = new Answer($_GET["ans_id"]);
			$form_id = $ans->getFormId();
		}
		$form = new Form($form_id);

		if($form->getAnonymous()) // Anonymous allowed if anonymous form
			return;

		$user = new User($_SESSION["user_id"]);
		$forms = $user->getDestinatairesForms(); // Returns validated (creation) forms
		foreach ($forms as $f) {
			if($f->getId() == $form_id){
				$b1 = TRUE;
				break;
			}
		}
		$b1 ? TRUE : header("Location: error.php?e=4" );

		if(isset($_GET["form_id"])){
			$max = $form->getMaxAnswers();
			$current = count($form->getListRecipient([$_SESSION["user_id"]]));
			$b2 = $max - $current > 0;
			$b2 ? TRUE : header("Location: error.php?e=5" );
		}
	}
?>
