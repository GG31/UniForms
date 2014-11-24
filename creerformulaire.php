<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="res/img/favicon.png" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>

	<!--start container-->
	<div id="container">

		<!--start header-->
		<header>

			<!--start logo-->
			<a href="index.php" id="logo"><img
				src="res/img/logo_UNS_couleurs_web.png" alt="logo" /></a>
			<!--end logo-->

			<!--start menu-->

			<!--end menu-->
		<?php include('include/nav.php'); ?>
   <!--end header-->
		</header>

		<!--start intro-->

		<div id="intro">
<?php
session_start ();
echo "<h3><center><B>Création de formulaire</B></center></h3>";
/**$random = substr( md5(rand()), 0, 7);
//echo $random;
$_SESSION['id_form'] = $random;
 *
 */

// echo $_SESSION['user'];
?>  
<form action="ajouter_form_user.php" method="post">
				<input type="submit" value="Valider">
</form>
		</div>
		<!--end intro-->
		<!--start holder-->
		<!-- fin du formulaire -->
	</div>
	<!--end container-->

	<!--start footer-->
		<?php include('include/footer.php'); ?>
   <!--end footer-->
</body>
</html>
