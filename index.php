<!doctype html>
<?php include 'php/include/login.php'; ?>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="res/img/favicon.png" />
<link rel="stylesheet" href="lib/bootstrap-3.3.1/css/min.css"
	type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />

<script src="lib/jquery-2.1.1/min.js"></script>
<script src="lib/bootstrap-3.3.1/js/min.js"></script>
</head>
<body>
	<div class="container">
			<?php include 'php/include/header.php'; ?>
			<form class="form-horizontal panel panel-primary" role="form"
			action="index.php" method="post">
			<!-- No need for .row with .form-horizontal-->
			<div class="panel-heading text-center">
				<div class="panel-title">
					<strong>Choix du mode d'authentification</strong>
				</div>
			</div>
			<div class="panel-body">
					<div class="form-group">
						 <center><B><a href="IndexCas.php">Utilisateurs CAS</a></B></center>
					</div>
				
					<div class="form-group">
						<center><B><a href="indexOther.php">Autres utilisateurs</a></B></center>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="form-group">
				</div>
			</div>
		</form>
			<?php include 'php/include/footer.php'; ?>
		</div>
</body>
</html>
