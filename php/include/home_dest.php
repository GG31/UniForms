<?php
	include_once ('include/includes.php');
   //$user = new User($_SESSION["user_id"]); // TODO $_SESSION["user_id"]
	//$crea = $user->getCreatedForms();

	//$user = new User($_GET["user_id"]); // TODO $_SESSION["user_id"]
	$user = new User($_SESSION["user_id"]); // TODO $_SESSION["user_id"]
	$dests = $user->getDestinatairesForms();
?>
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
			<?php
				foreach($dests as $dest) {
					if($dest->getStateOf($_SESSION["user_id"]) == 1){
			?>
						<tr class="success">
							<td><?php echo $dest->getId() ?></td>
							
							
							
							<td>Envoyé</td>
							<td><a href="fillform.php?id=<?php echo $dest->getId() ?>">Voir</a></td>
						</tr>
			<?php
					}else{
			?>
						<tr class="info">
							<td><?php echo $dest->getId() ?></td>
							<td>Non envoyé</td>
							<td><a href="fillform.php?id=<?php echo $dest->getId() ?>">Modifier</a></td>
						</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
