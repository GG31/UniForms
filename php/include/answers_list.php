<?php
	if(!isset($_GET["user_id"])){
?>
<?php
	include_once('class/DBSingleton.class.php');
	DBSingleton::getInstance();
	include_once("class/Form.class.php");

	$form = new Form($_GET["form_id"]);
	$dest = $form->getAllFormReceivers(1);
?>
<div class="panel panel-default">
	<div class="panel-heading">Personnes ayant soumis le formulaire <?php echo $_GET["form_id"] ?></div>

	<table class="table table-hover"><!-- table-hover vs table-striped -->
		<thead>
			<tr>
				<th>Users</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($line = mysql_fetch_array($dest)){
					var_dump($line);
					echo '<br>';
					echo '<br>';
			?>
				<tr class="success">
					<td><?php echo $line["user_id"] ?></td>
					<td><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $line["user_id"] ?>">Voir</a> (CSV BDD coming soon...)</td>
				</tr>
			<?php 
				}
			?>
		</tbody>
	</table>
</div>
<?php
	}
?>