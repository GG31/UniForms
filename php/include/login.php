<?php
session_start ();

// Redirects user to HOME if already logged
if (isset ( $_SESSION ["user_id"] )) {
	header ( "Location: php/home.php" );
}

// Taking care of login form submission
if (isset ( $_POST ["login"] )) { // AND isset ( $_POST["password"] )
	include "connect.php";
	
	// Asking for table row with matching USER_NAME
	$q = mysql_query ( "SELECT * FROM user WHERE user_name = '" . $_POST ["login"] . "'" );
	$line = mysql_fetch_array ( $q );
	
	if ($line != FALSE) { // Something were found
	                    // Saving USER_ID & USER_NAME in SESSION
		$_SESSION ['user_id'] = $line ["user_id"];
		//to add, external BDD
		$_SESSION ['name'] = $line ["user_name"];
		// Going HOME
		header ( "Location: php/home.php" );
	} else { // Nothing found
	       // Back to the form
		header ( "Location: index.php?WRONG LOG/PSW" );
	}
}
?>  