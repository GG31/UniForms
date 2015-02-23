<?php
	$user = new User ( $_SESSION ["user_id"] );
	$forms = $user->getDestinatairesForms();
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize">
		<h3 class="panel-title">
			<strong>Formulaires pour lesquels je suis destinataire</strong>
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
				foreach($forms as $f) {
			?>
					<tr class="">
						<td><?php echo $f->getId() ?> </td>
						<td>Formulaire <?php echo $f->getId() ?></td>
						<td><a href="list.php?form_id=<?php echo $f->getId() ?>">Voir les instances</a>
						</td>
					</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</div>
