<?php
	$user = new User($_SESSION["user_id"]);
	$dest = $user->getDestinatairesForms();
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize">
		<h3 class="panel-title"><strong>Formulaires pour lesquels je suis destinataire</strong></h3>
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
				foreach($dest as $d) {
					$a = $d->getAnswer([$user->getId()])[0];
					if($a->getState() == TRUE){
			?>
						<tr class="success">
							<td><?php echo $d->getId() ?></td>
							<td>Envoyé</td>
							<td><a href="fillform.php?ans_id=<?php echo $a->getId() ?>">Voir</a></td>
						</tr>
			<?php
					}else{
			?>
						<tr class="info">
							<td><?php echo $d->getId() ?></td>
							<td>Non envoyé</td>
							<td><a href="fillform.php?ans_id=<?php echo $a->getId() ?>">Modifier</a></td>
						</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
