<?php
	// This file must be included in every page after the login. It verifies if there is a logged user.
	session_start();
	if(!isset($_SESSION["user_id"])){
		/*if( explode('.', basename($_SERVER["REQUEST_URI"]), 2)[0] == "fillform" AND isset($_GET["ans_id"]) ){
			$q = mysql_query("SELECT user_id FROM formdest JOIN formans ON formdest.formdest_id = formans.formdest_id WHERE formdans_id =" . $_GET["ans_id"]);
			$line = mysql_fetch_array($q);
			echo "string";
			var_dump($line);
			if($line["user_id"] != 0){
				$_SESSION["user_id"] = 0;
				header ( "Location: ../index.php" );
			}
		}else{
			header ( "Location: ../index.php" );
		}*/

		header ( "Location: ../index.php" ); // nosession=1
	}
?>