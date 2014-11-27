<?php
   include ('include/includes.php');
?>
<!doctype html> 
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
			<header class="row page-header">
				<?php include 'include/header.php'; ?>
			</header>
			<div class="row">
				<?php include 'include/nav.php'; ?>
			</div>
			<div class="row">
				<?php include 'include/home_created.php'; ?>
			</div>
			<div class="row">
				<?php include 'include/home_dest.php'; ?>
			</div>
			<footer class="row well">
				<?php include 'include/footer.php'; ?>
			</footer>
		</div>
	</body>
</html>
