<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="res/img/favicon.png" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>
	<div id="container">
      <div class="row">
         <?php include('php/include/header.php'); ?>
      </div>
      <div class="col-sm-offset-6 col-sm-4">
		   <?php include('include/nav.php'); ?>
      </div>
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
	</div>
	<div class="row">
		<?php include('include/footer.php'); ?>
	</div>
</body>
</html>
