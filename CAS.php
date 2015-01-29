<?php
	session_start ();
	
	// Load the CAS lib
	include_once ('CAS/CAS.php');
	
	// Initialize phpCAS
	phpCAS::client ( CAS_VERSION_2_0, 'login.unice.fr', 443, '' );
	
	// For quick testing you can disable SSL validation of the CAS server.
	// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
	// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
	phpCAS::setNoCasServerValidation ();
	
	// force CAS authentication
	phpCAS::forceAuthentication ();
	
	// at this step, the user has been authenticated by the CAS server
	// and the user's login name can be read with phpCAS::getUser().
	$_SESSION ['CAS_id'] = phpCAS::getUser ();
	header ( "Location: php/loginCAS.php" );
	// logout if desired
	/*if (isset($_REQUEST['logout'])) {
		phpCAS::logout();
	}*/

	// for this test, simply print that the authentication was successfull
	?>
<!--<html>
<head>
<title>phpCAS simple client</title>
</head>
<body>
	<h1>Successfull Authentication!</h1>
<p>
		the user's login is <b><?php //echo phpCAS::getUser(); ?></b>.
	</p>
	<h3>User Attributes</h3>
	<ul>
	<?php
		/*foreach (phpCAS::getAttributes() as $key => $value) {
			if (is_array($value)) {
				echo '<li>', $key, ':<ol>';
				foreach ($value as $item) {
					echo '<li><strong>', $item, '</strong></li>';
				}
				echo '</ol></li>';
			} else {
				echo '<li>', $key, ': <strong>', $value, '</strong></li>' . PHP_EOL;
			}
		}*/
	?>
	</ul>
	<p>
		<a href="?logout=">Logout</a>
	</p>
</body>
</html>