<?php
	/*
		Triggers verification
	 */
	//var_dump($_SESSION["user_id"]);echo "<br>";
	switch (explode('.', basename($_SERVER["REQUEST_URI"]), 2)[0]) {
		case 'answers':
			// var_dump(verify_access_answers());
			verify_access_answers();
			break;
		case 'createform':
			//var_dump(verify_access_create());
			verify_access_create();
			break;
		case 'fillform':
			//var_dump(verify_access_fill());
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
	function verify_access_answers(){
		$b1 = FALSE;
		$b2 = TRUE;

		if(isset($_GET["form_id"])){
			$b1 = (new User($_SESSION["user_id"]))->isCreator($_GET["form_id"]);
			$b1 ? TRUE : header("Location: error.php?e=1" );

			if(isset($_GET["user_id"])){
				$ans = (new Form($_GET["form_id"]))->getAnswer([$_GET["user_id"]], 1);
				$b2  = count($ans) == 1 ? TRUE : FALSE;
				$b2 ? TRUE : header("Location: ../error.php?e=2" );
			}
		}
	}

	/*
		CREATEFORM.PHP:
			$_GET["form_id"]:
				$_SESSION["user_id"] is creator of $_GET["form_id"]
			void:
				ok
	 */
	function verify_access_create(){
		$b = TRUE;

		if(isset($_GET["form_id"])){
			$b = (new User($_SESSION["user_id"]))->isCreator($_GET["form_id"]);
			$b ? TRUE : header("Location: error.php?e=3" );
			//$error = $b1 ? "" : "Vous nêtes pas le créateur de ce formulaire !";
		}
	}

	/*
		FILLFORM.PHP: TODO
			$_GET["ans_id"]:
				$_SESSION["user_id"] is dest of form
				form is validated (creation)

	 */
	function verify_access_fill(){
		$error = "";
		$b1 = FALSE;
		$b2 = FALSE;

		if(isset($_GET["ans_id"])){
			$ans = new Answer($_GET["ans_id"]);
			$form_id = $ans->getForm();

			$f 	 = new Form($form_id);
			$b1  = $f->getState() == TRUE;
			$b1 ? TRUE : header("Location: error.php?e=4" );
			//$error = $b1 ? "" : "Ce formulaire n'existe pas !";

			if($b1){
				$b2  = $ans->getUser()->getId() == $_SESSION["user_id"];
				$b2 ? TRUE : header("Location: error.php?e=5" );
				//$error = $b2 ? "" : "Ce formulaire ne vous est pas destiné !";
			}
		}
	}
?>