<?php
	$user = new User($_SESSION["user_id"]);
	$forms = $user->getDestinatairesForms();
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
				foreach($forms as $f) {
					$list = $f->getListRecipient([$user->getId()], 0);//([$user->getId()])[0];
					if(count($list)){
						$null  = FALSE;
						foreach ($list as $line) {
							if($line["Answer"] == NULL){
								$null = TRUE;
							}
						}
						if($null){
			?>
							<tr class="info">
								<td><?php echo $f->getId() ?></td>
								<td>Formulaire <?php echo $f->getId() ?></td>
								<td><a href="fillform.php?form_id=<?php echo $f->getId() ?>">Nouvelle réponse</a></td>
							</tr>
			<?php
						}else{
			?>
							<tr class="warning">
								<td><?php echo $f->getId() ?></td>
								<td>Formulaire <?php echo $f->getId() ?></td>
								<td></td>
							</tr>
			<?php
						}
						foreach ($list as $key => $line) {
							if($line["Answer"] != NULL){
			?>
								<tr class="info">
									<td>"</td>
									<td>Réponse : <?php echo $key ?></td>
									<td><a href="fillform.php?ans_id=<?php echo $line["FormDestId"] ?>">Modifier</a></td>
								</tr>
			<?php
							}
						}
					}
				}
			?>
		</tbody>
	</table>
</div>
