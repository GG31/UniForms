<?php
	/*
		Triggers verification
	 */
	switch (explode('.', basename($_SERVER["REQUEST_URI"]), 2)[0]) {
		case 'createform':
			if (isset($_GET["form_id"])) 
				verify_creator($_GET["form_id"]); 
			elseif ($_SESSION["user_id"] == 0) 
				header("Location: include/logout.php" );
			break;
		case 'fillform':
			verify_access_fill();
			break;
		case 'download_csv':
			if (isset($_GET["form"]) || isset($_GET["ans"]))
				verify_creator($_GET["form"], $_GET["ans"]); 
			else 
				header ( "Location: error.php?e=99" );
			break;
		case 'exportSQL':
		case 'results':
			if (isset($_GET["form"])) 
				verify_creator($_GET["form"]); 
			else 
				header ( "Location: error.php?e=99" );
			break;
		case 'formresult':
			if (isset($_GET["ans_id"]) and $_SESSION["user_id"]) 
				verify_ans_id($_GET["ans_id"]);
			else
				header ( "Location: error.php?e=99" );
			break;
	    default:
			if ($_SESSION["user_id"] == 0) {
				header("Location: include/logout.php" );
			}
			break;
	}
	
	/* Verifies if current user is creator of $formId */
	function verify_creator($formId, $ansId = NULL ) {
		if(isset($formId)){
			$creatorId = (new Form($formId))->creator()->id();
		}elseif(isset($ansId)){
			$creatorId = (new Form((new Answer($ansId))->formId()))->creator()->id();
		}else{
			header ( "Location: error.php?e=3" );
		}

		if (!($creatorId == $_SESSION ["user_id"]))
			header ( "Location: error.php?e=3" );
	}
	
	/* Verifies if current user is creator of form of $ansId */
	function verify_ans_id($ansId = null) {
		if (!((new Form((new Answer($ansId))->formId()))->creator()->id() == $_SESSION ["user_id"]))
			header ( "Location: error.php?e=3" );
	}

	/* Verifies access to fill form page */
	function verify_access_fill(){
		if(isset($_GET["form_id"]) and isset($_GET["formdest_id"]) and isset($_GET["prev_id"])){
			$form = new Form($_GET["form_id"]);
			if((!$form->anon()) and $_SESSION["user_id"] == 0)
				header("Location: include/logout.php" );
			if($form->state() == FALSE)
				header ( "Location: error.php?e=99" );
			if((new User($_SESSION["user_id"]))->isFormIdRecipient($_GET["formdest_id"]) == FALSE)
				header ( "Location: error.php?e=4" );
			if ((new User($_SESSION["user_id"]))->isLimitReached($_GET["formdest_id"]))
				header ( "Location: error.php?e=5" );
			//  prev id
		}elseif(isset($_GET["ans_id"])){
			if ((new Answer($_GET["ans_id"]))->userId() != $_SESSION["user_id"])
				header ( "Location: error.php?e=4" );
		}else{
			header ( "Location: error.php?e=99" );
		}
	}
?>
