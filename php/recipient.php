<?php
	include_once 'include/includes.php';

	if(!isset($_SESSION["user_id"]))
		return;

	$userId = $_SESSION["user_id"];

	$user 		= new User($userId);
	$recipient 	= $user->recipient();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
			type="text/css" />
		<link rel="stylesheet" href="../css/styles.css" type="text/css" />
		<link rel="shortcut icon" href="../res/img/favicon.png" />
		<script src="../lib/jquery-2.1.1/min.js"></script>
		<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
	</head>
	<body>
		<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading text-center text-capitalize">
						<h3 class="panel-title">
							<strong>Boîte de réception</strong>
						</h3>
					</div>
<?php
	if(count($recipient) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<th>Nom</th>
								<th>Archives</th>
							</tr>
						</thead>
						<tbody>
<?php
		foreach($recipient as $form){
			$id = $form->id();
			$name = $form->name();
			$status = $form->state();
?>
							<tr class="info">
								<td><a href="form.php?form=<?php echo $id ?>"><?php echo $name ?></a></td>
								<td><a href="formarchive.php?form=<?php echo $id ?>">Aller</a></td>
							</tr>
<?php
		}
?>
						</tbody>
					</table>
<?php
	}
?>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>