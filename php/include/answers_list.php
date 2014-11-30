<?php
	if(isset($_GET["form_id"]) AND !isset($_GET["user_id"])){

		$form = new Form($_GET["form_id"]);
		$ans = $form->getAnswer([], 1);
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize"><strong>Personnes ayant soumis le formulaire <?php echo $_GET["form_id"] ?></strong></div>

	<table class="table table-hover"><!-- table-hover vs table-striped -->
		<thead>
			<tr>
				<th>Destinataires</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($ans as $a){

			?>
				<tr class="success">
					<td><?php echo $a->getUser()->getName() ?></td>
					<td><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $a->getUser()->getId() ?>">Voir</a> (CSV BDD coming soon...)</td>
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