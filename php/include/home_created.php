<?php
   include_once ('include/includes.php');
   $user = new User($_SESSION["user_id"]);
   $creas = $user->getCreatedForms();
?> 
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
			<?php
				foreach($creas as $crea) {
					if($crea->getState() == 1){
			?>
						<tr class="success">
							<td><?php echo $crea->getId() ?></td>
							<td>Validé</td>
							<td><a href="answers.php?form_id=<?php echo $crea->getId() ?>">Voir résultats</a></td>
						</tr>
			<?php
					}else{
			?>
						<tr class="info">
							<td><?php echo $crea->getId() ?></td>
							<td>Non validé</td>
							<td><a href="modifyform.php?id=<?php echo $crea->getId() ?>">Modifier</a></td>
						</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
