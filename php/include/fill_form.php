<?php
	include_once 'includes.php';
		
		if (! empty ( $_POST )) {
			$ans = new Answer($_POST["ans_id"]);
			
			if(isset($_POST["save"])){
				$ans->save();
			}
			if(isset($_POST["send"])){
				$ans->send();
			}
			header( "Location: ../home.php" );
		}


?>