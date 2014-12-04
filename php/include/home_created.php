<?php
$user = new User ( $_SESSION ["user_id"] );
$creas = $user->getCreatedForms ();
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize">
		<h3 class="panel-title">
			<strong>Formulaires que j'ai crée</strong>
		</h3>
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Form</th>
				<th>Etat</th>
				<th>Action</th>
				<th>Supprimer</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( $creas as $crea ) {
				if ($crea->getState () == 1) {
					?>
						<tr class="success">
				<td><?php echo $crea->getId() ?></td>
				<td>Validé</td>
				<td><a href="answers.php?form_id=<?php echo $crea->getId() ?>">Voir
						résultats</a></td>
			   <td><a href="deleteform.php?form_id=<?php echo $crea->getId() ?>" class="text-muted"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td>
			</tr>
			<?php
				} else {
					?>
						<tr class="info">
				<td><?php echo $crea->getId() ?></td>
				<td>Non validé</td>
				<td><a href="createform.php?form_id=<?php echo $crea->getId() ?>">Modifier</a></td>
				<td><a href="deleteform.php?form_id=<?php echo $crea->getId() ?>" class="text-muted"> <span  class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> </td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>
