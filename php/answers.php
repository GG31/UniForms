<!doctype html>
<?php include_once ('include/includes.php'); ?>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css"
	type="text/css" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>
</head>
<body>
	<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<div class="row">
				<?php include 'include/answers_list.php'; ?>
			</div>
		<!-- 2 rows -->
				<?php include 'include/answers_form.php'; ?>
			<!--/2 rows -->
			<?php include 'include/footer.php'; ?>
		</div>
</body>
</html>
