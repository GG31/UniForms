<?php
// This file must be included in every page after the login. It verifies if there is a logged user.
session_start();
if(!isset($_SESSION["user_id"])){
	header ( "Location: ../index.php?nosession=1" );
}
//else if(!mysql_num_rows(mysql_query("SELECT * FROM user WHERE id_user = ".$_SESSION["id_user"])))
	//header ( "Location: ../index.php?nosession=1" );

?>