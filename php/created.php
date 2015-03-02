<?php
	include_once 'include/includes.php';

	if(!isset($_SESSION["user_id"]))
		return;

	$userId = $_SESSION["user_id"];

	$user 		= new User($userId);
	$created 	= $user->created();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
			type="text/css" />
		<link rel="shortcut icon" href="../res/img/favicon.png" />
		<link rel="stylesheet" href="../css/styles.css" type="text/css" />

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
							<strong>Mes formulaires</strong>
						</h3>
					</div>
<?php
	if(count($created) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<th>Nom</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
<?php
		foreach($created as $form){
			$formId = $form->id();
			$name = $form->name();
			$status = $form->state();

			if($status == TRUE){
				$link = "results.php?form=$formId";
			}else{
				$link = "createform.php?form_id=$formId";
			}
?>
							<tr class="info">
								<td><a href="<?php echo $link ?>"><?php echo $name ?></a></td>
								<?php
									if($status == TRUE){
								?>
								<td>Validé</td>
								<?php
									}else{
								?>
								<td>A valider
									<a href="include/deleteform.php?form_id=<?php echo $formId ?>" class="text-muted">
										<span class="glyphicon glyphicon-trash" aria-hidden="true" onclick="return confirm('Voulez-vous vraiment supprimer ?');">
										</span>
									</a>
								</td>
								<?php
									}
								?>
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