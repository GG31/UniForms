<?php
	if(isset($_GET["form_id"]) AND !isset($_GET["user_id"])){
		$user = new User($_SESSION["user_id"]);
		$form = new Form($_GET["form_id"]);
		$list = $form->getListRecipient([], 1);
?>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize"><strong>Personnes ayant soumis le formulaire <?php echo $_GET["form_id"] ?></strong></div>

	<table class="table table-hover"><!-- table-hover vs table-striped -->
		<thead>
			<tr>
				<th>Destinataires</th>
				<th>Action</th>
				<th><a href="include/download_all_csv.php?ans_id=<?php echo $list[1]["formDestId"]; ?>"> <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span></a> Download Results</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ( $list as $key => $line ){
			?>
				<tr class="success">
					<td><?php echo $line["User"]->getName(); ?></td>
					<td><a href="answers.php?ans_id=<?php echo $line["formDestId"] ?>">Voir</a> (CSV BDD coming soon...)</td>
					<!-- <td><a href="include/download_csv.php?form_id=<?php //echo $_GET["form_id"] ?>&user_id=<?php //echo $a->getUser()->getId() ?>">Download in CSV format</a></td> -->
					<!-- <td><a href="include/download_all_csv.php?ans_id=<?php //echo $line["formDestId"] ?>"> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a> (CSV format)</td> -->
					<td><a href="include/download_csv.php?ans_id=<?php echo $line["formDestId"]."&user_id=".$line["User"]->getId(); ?>"> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a> (CSV format)</td>
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