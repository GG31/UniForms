<?php

	// /////////////////////
	// // Error enabling //
	// /////////////////////
	ini_set('display_errors', 1);
	error_reporting ( E_ALL );

	require_once_UF ( "include/connect" );
	require_once_UF ( "class/User.class" );
	require_once_UF ( "class/Form.class" );
	require_once_UF ( "class/Answer.class" );
	require_once_UF ( "class/Element.class" );
	require_once_UF ( "class/FormGroup.class" );

	///////////////////
	// Getting form //
	///////////////////
	
	if(!isset($_GET["formId"])){
		echo "?formId=???";
		return;
	}

	$form = new Form($_GET["formId"]);

	

	l("yep");

	function require_once_UF($path) {
		require_once dirname ( __FILE__ ) . '/' . $path . '.php';
	}

	function l($obj){
		if(is_array($obj)){
			echo '<pre>';
			print_r($bj);
			echo '</pre>';
			return;
		}
		if(is_object($obj)){
			var_dump($obj);
			return;
		}
		echo $obj;
		return;
	}

?>