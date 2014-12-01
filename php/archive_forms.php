<!doctype html>
<?php
include_once 'include/includes.php';
$user = new User ( $_SESSION ["user_id"] );
$dest = $user->getDestinatairesForms ();
?>
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
			<div class="panel panel-primary">
				<div class="panel-heading text-center text-capitalize">
					<h3 class="panel-title">
						<strong>Formulaires pour lesquels je suis destinataire -Etat:EnvoyerValider-</strong>
					</h3>
				</div>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>Form</th>
							<th>Etat</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
			<?php
			foreach ( $dest as $d ) {
				$a = $d->getAnswer ( [ 
						$user->getId () 
				] )[0];
				if ($a->getState () == TRUE) {
					?>
						<tr class="success">
							<td><?php echo $d->getId() ?></td>
							<td>Envoyé</td>
							<td><a href="fillform.php?ans_id=<?php echo $a->getId() ?>">Voir</a></td>
						</tr>
			<?php
				}
			}
			?>
		</tbody>
				</table>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
</div>
</body>
</html>
