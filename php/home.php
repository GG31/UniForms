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
					<div class="panel-heading">Formulaires que j'ai crée</div>

					<table class="table table-hover"><!-- table-hover vs table-striped -->
						<thead>
							<tr>
								<th>Form</th>
								<th>Etat</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr class="info">
								<td>Mettre une ampoule dans les toilettes</td>
								<td>Non validé</td>
								<td><a href="createform.php?id=">Modifier</a></td>
							</tr>
							<tr class="success">
								<td>Arrêter de pleuvoir</td>
								<td>Validé</td>
								<td><a href="answers.php?formid=">Voir résultats</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">Formulaires pour lesquels je suis destinataire</div>

					<table class="table table-hover"><!-- table-hover vs table-striped -->
						<thead>
							<tr>
								<th>Form</th>
								<th>Etat</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr class="info">
								<td>Mer ou montagne ?</td>
								<td>Non envoyé</td>
								<td><a href="fillform.php?id=">Modifier</a></td>
							</tr>
							<tr class="success">
								<td>Da bomb yo</td>
								<td>Envoyé</td>
								<td><a href="fillform.php?id=">Voir</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>
