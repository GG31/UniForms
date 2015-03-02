<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../../res/img/favicon.png" />
<link rel="stylesheet" href="../../lib/bootstrap-3.3.1/css/min.css"
	type="text/css" />
<link rel="stylesheet" href="../../css/styles.css" type="text/css" />
</head>
<body>
	<div class="container">
			<?php include '../../php/include/header.php'; ?>
			
			<div class="row">
				<div class="alert alert-danger text-center" role="alert">
						ERREUR : Impossible de se connecter à la base de données<br>
						Vérifier les informations et <a href="Installer.php"  class="btn btn-warning" role="button">réessayer</a>
				</div>
			</div>
			
			<?php include '../../php/include/footer.php'; ?>
	</div>
</body>
</html>