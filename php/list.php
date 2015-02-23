<!doctype html>
<?php include_once 'include/includes.php'; ?>
<html>
	<head>
	<meta charset="UTF-8">
	<title>UniForms</title>
	<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
		type="text/css" />
	<link rel="stylesheet" href="../css/styles.css" type="text/css" />

	<script src="../lib/jquery-2.1.1/min.js"></script>
	<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
</head>
<body>
	<div class="container">
		<?php include 'include/header.php'; ?>
		<?php include 'include/nav.php'; ?>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<div class="row">
<?php
	$user = new User ( $_SESSION ["user_id"] );
	$form = new Form($_GET["form_id"]);
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize">
		<h3 class="panel-title">
			<strong><?php echo $form->getName();?></strong>
		</h3>
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>AAAAAAAA</th>
			</tr>
		</thead>
		<tbody>
			<?php
					$groups = $form->getGroups();
					// echo "<pre>";
					// var_dump($groups);
					// echo "</pre>";
					foreach ($groups as $group) {
						$max 		= $group->getMaxAnswers();
						$num 		= $group->getNumber();
						$answers	= $group->getRecipients([$user->getId()]);

			?>
						<tr class="">
							<td>Group</td>
						</tr>
			<?php
						foreach ($answers as $ans) {
							$status = $ans["Status"];

							if(!$status){
			?>
							<tr class="">
								<td>Réponse</td>
								<td><a href="fillform.php?ans_id=<?php echo $ans["formDestId"] ?>">Modifier</a></td>
							</tr>
			<?php
							}
						}
					}
			?>

			<?php
				/*
							<tr class="">
								<td><?php echo $f->getId() ?> </td>
								<td>Formulaire <?php echo $f->getId() ?></td>
								<td><a href="fillform.php?form_id=<?php echo $f->getId() ?>">Nouvelle réponse</a>
								</td>
							</tr>
								<tr class="">
									<td><?php echo $f->getId() ?> </td>
									<td>Formulaire <?php echo $f->getId() ?></td>
									<td><a href="fillform.php?form_id=<?php echo $f->getId() ?>">Nouvelle réponse</a>
										<span class="badge alert-success">
										<?php echo $remaining ?> restante<?php echo $remaining > 1 ? "s" : "" ?></span>
									</td>
								</tr>
								<tr class="">
									<td><?php echo $f->getId() ?></td>
									<td>Formulaire <?php echo $f->getId() ?></td>
									<td></td>
								</tr>
								if status false : <tr class="info">
									<td>"</td>
									<td>Réponse : <?php echo $key ?></td>
									<td><a href="fillform.php?ans_id=<?php echo $line["formDestId"] ?>">Modifier</a></td>
								</tr>
				*/
			?>
		</tbody>
	</table>
</div>


<!-- ////////////////////////////////////////////////////////////////////////////////////////////////// -->




			</div>
			<?php include 'include/footer.php'; ?>
		</div>
</body>
</html>