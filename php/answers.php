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
			<?php include 'include/header.php'; ?>
			<div class="row">
				<?php include 'include/nav.php'; ?>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">Formulaires soumis</div>

					<table class="table table-hover"><!-- table-hover vs table-striped -->
						<thead>
							<tr>
								<th>Users</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr class="info">
								<td>Bernard</td>
								<td>Voir CSV BDD</td>
							</tr>
							<tr class="success">
								<td>Jacques</td>
								<td>Voir CSV BDD</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>
