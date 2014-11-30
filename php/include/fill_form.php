<?php
	include_once 'includes.php';
		
		if (! empty ( $_POST )) {
			var_dump($_POST);
			echo "<br>";
			
			$ans = new Answer($_POST["ans_id"]);
			var_dump($ans);
			
			if(isset($_POST["save"])){
				$ans->save();
			}
			if(isset($_POST["send"])){
				$ans->send();
			}
		}


?>