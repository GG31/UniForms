<?php
	if(!isset($_GET["user_id"])){
?>
<?php
	include_once('include/includes.php');

	$form = new Form($_GET["form_id"]);
	$dest = $form->getRecipient();
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
				foreach($dest as $d){
			?>
				<tr class="success">
					<td><?php echo $d->getId() ?></td>
					<td><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $d->getId() ?>">Voir</a> (CSV BDD coming soon...)</td>
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