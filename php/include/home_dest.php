<?php
	include_once('class/DBSingleton.class.php');
	DBSingleton::getInstance();
	include_once("class/User.class.php");

	$user = new User(3); // TODO $_SESSION["user_id"]
	$dest = $user->getDestForms();
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
				while($line = mysql_fetch_array($dest)){
					if($line["status"] == 1){
			?>
						<tr class="success">
							<td><?php echo $line["form_id"] ?></td>
							<td>Envoyé</td>
							<td><a href="fillform.php?id=<?php echo $line["form_id"] ?>">Voir</a></td>
						</tr>
			<?php
					}else{
			?>
						<tr class="info">
							<td><?php echo $line["form_id"] ?></td>
							<td>Non envoyé</td>
							<td><a href="fillform.php?id=<?php echo $line["form_id"] ?>">Modifier</a></td>
						</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>