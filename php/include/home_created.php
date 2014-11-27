<?php
   include_once ('include/includes.php');
   $user = new User($_SESSION["user_id"]); // TODO $_SESSION["user_id"]
	$crea = $user->getCreatedForms();
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
				while($line = mysql_fetch_array($crea)){
					if($line["status"] == 1){
			?>
						<tr class="success">
							<td><?php echo $line["form_id"] ?></td>
							<td>Validé</td>
							<td><a href="answers.php?form_id=<?php echo $line["form_id"] ?>">Voir résultats</a></td>
						</tr>
			<?php
					}else{
			?>
						<tr class="info">
							<td><?php echo $line["form_id"] ?></td>
							<td>Non validé</td>
							<td><a href="createform.php?id=<?php echo $line["form_id"] ?>">Modifier</a></td>
						</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
