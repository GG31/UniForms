<?php
	/*
		Trigger verification
	 */
	var_dump($_SESSION["user_id"]);echo "<br>";
	switch (explode('.', basename($_SERVER["REQUEST_URI"]), 2)[0]) {
		case 'answers':
			var_dump(verify_access_answers());
			//verify_access_answers() ?: header ( "Location: NEIN!" );
			break;
		case 'createform':
			var_dump(verify_access_create());
			//verify_access_create() ?: header ( "Location: NEIN!" );
			break;
		case 'fillform':
			var_dump(verify_access_fill());
			//verify_access_fill() ?: header ( "Location: NEIN!" );
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
			if(isset($_GET["user_id"])){
				$ans = (new Form($_GET["form_id"]))->getAnswer([$_GET["user_id"]], 1);
				$b2  = count($ans) == 1 ? TRUE : FALSE;
			}
		}

		return $b1 AND $b2;
	}

	/*
		CREATEFORM.PHP:
			$_GET["form_id"]:
				$_SESSION["user_id"] is creator of $_GET["form_id"]
				$_GET["form_id"] is not yet validated (creation)
			void:
				ok
	 */
	function verify_access_create(){
		$b2 = TRUE;
		$b1 = TRUE;

		if(isset($_GET["form_id"])){
			$b1 = (new User($_SESSION["user_id"]))->isCreator($_GET["form_id"]);
			$b2 = (new Form($_GET["form_id"]))->getState() == FALSE;
		}

		return $b1 AND $b2;
	}

	/*
		FILLFORM.PHP:
			$_GET["form_id"]:
				$_SESSION["user_id"] is dest of $_GET["form_id"]
				$_GET["form_id"] is validated (creation)
				$_GET["form_id"] is not yet validated (answer) by $_SESSION["user_id"]

	 */
	function verify_access_fill(){
		$b1 = FALSE;
		$b2 = FALSE;
		$b3 = FALSE;

		if(isset($_GET["form_id"])){
			$b1  = (new User($_SESSION["user_id"]))->isDestinataire($_GET["form_id"]);
			$f 	 = new Form($_GET["form_id"]);
			$b2  = $f->getState() == TRUE;
			$ans = $f->getAnswer([$_SESSION["user_id"]], 0);
			$b3  = count($ans) == 1 ? TRUE : FALSE;
		}

		return $b1 AND $b2 AND $b3;
	}
?>