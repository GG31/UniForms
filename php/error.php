<!doctype html> 
<?php include_once 'include/includes.php'; ?>
<?php
	switch($_GET["e"]){
		case 1:
			$error = "Vous n'êtes pas le créateur de ce formualire !";
			break;
		case 2:
			$error = "Cette personne n'a pas répondu à ce formulaire !";
			break;
		case 3:
			$error = "Vous nêtes pas le créateur de ce formulaire !";
			break;
		case 4:
			$error = "Ce formulaire n'existe pas !";
			break;
		case 5:
			$error = "Ce formulaire ne vous est pas destiné !";
			break;
		default:
			$error = "Il semblerait qu'il y ait eu une erreur !";
			break;
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css" type="text/css" />
		<link rel="stylesheet" href="../css/styles.css" type="text/css" />

		<script src="../lib/jquery-2.1.1/min.js"></script>
		<script src="../lib/bootstrap-3.3.1/min.js"></script>
	</head>
	<body>
		<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<div class="row">
				<div class="alert alert-danger text-center" role="alert">
					<?php echo $error ?>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>
