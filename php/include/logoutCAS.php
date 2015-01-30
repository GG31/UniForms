<?php
session_start ();
	// Load the CAS lib
	include_once ('../../CAS/CAS.php');
	// Initialize phpCAS
	phpCAS::client ( CAS_VERSION_2_0, 'login.unice.fr', 443, '' );
session_destroy ();
phpCAS::logout();
header ( "Location: ../../index.php" );
?>