<?php
session_start ();
if (isset ( $_SESSION ["user_id"] )) {
	header ( "Location: home.php" );
}

if (isset ( $_SESSION ['CAS_id'] )) { 
	include "include/connect.php";
	
	// Asking for table row with matching USER_NAME
	$q = mysql_query ( "SELECT * FROM user WHERE user_name = '" . $_SESSION ['CAS_id'] . "'" ) or die('<br><strong>SQL Error (1)</strong>:<br>'.mysql_error());
	$line = mysql_fetch_array ( $q );
	
	if ($line != FALSE) { // Something were found
	                    // Saving USER_ID & USER_NAME in SESSION
		$_SESSION ['user_id'] = $line ["user_id"];
		// Going HOME
		header ( "Location: home.php" );
	} else { 
		$logcas = $_SESSION ['CAS_id'];
		$q = "INSERT INTO `user` (`user_name`) VALUES  ('$logcas')";
		mysql_query ($q);
		//$_SESSION ['user_id'] = $_SESSION ['CAS_id'];
		$_SESSION ['user_id'] = mysql_insert_id();
		header ( "Location: home.php" );
	}
}
?>  