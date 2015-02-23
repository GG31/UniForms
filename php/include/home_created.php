<?php
$user = new User ( $_SESSION ["user_id"] );
$creas = $user->getCreatedForms ();
?>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'top'
    });
});
</script>
<style type="text/css">
	.bs-example{
    	margin: 150px 50px;
    }
    .popover-examples{
        margin-bottom: 20px;
    }
</style>
<div class="panel panel-primary">
	<div class="panel-heading text-center text-capitalize">
		<h3 class="panel-title">
			<strong>Formulaires que j'ai crées</strong>
		</h3>
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Form</th>
				<th>Etat</th>
				<th>Action</th>
				<th></th>
				<!-- <th>URL</th> -->
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
						<td><?php  echo "<button type='button' class='btn btn-primary' data-toggle='popover' title='A copier' data-content='".$_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], "/"))."/fillform.php?form_id=".$crea->getId()."'>URL</button>"  ?> </td>
			   <td><a href="include/deleteform.php?form_id=<?php echo $crea->getId() ?>" class="text-muted"> <span class="glyphicon glyphicon-trash" aria-hidden="true" onclick="return confirm('Voulez-vous vraiment supprimer ?');"></span> </a></td>
			</tr>
			<?php
				} else {
					?>
						<tr class="info">
				<td><?php echo $crea->getId() ?></td>
				<td>Non validé</td>
				<td><a href="createform.php?form_id=<?php echo $crea->getId() ?>">Modifier</a></td>
				<td></td>	
				<td><a href="include/deleteform.php?form_id=<?php echo $crea->getId() ?>" class="text-muted"> <span  class="glyphicon glyphicon-trash" aria-hidden="true" onclick="return confirm('Voulez-vous vraiment supprimer ?');"></span> </a> </td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>
