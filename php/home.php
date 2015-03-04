<!doctype html>
<?php include_once 'include/includes.php'; 
   if(!isset($_SESSION["user_id"]))
		   return;

	   $userId = $_SESSION["user_id"];

	   $user 		= new User($userId);
	   $created 	= $user->created();
	   $recipient 	= $user->recipient();
?>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
	type="text/css" />
<link rel="shortcut icon" href="../res/img/favicon.png" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
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
</head>
<body>
	<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading text-center text-capitalize">
						<h3 class="panel-title">
							<strong>Mes derniers formulaires</strong>
						</h3>
					</div>
<?php
	if(count($created) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<th>Nom</th>
								<th></th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
<?php
      for ($nbForm = 0; $nbForm < 3 && count($created) > 0; $nbForm++) {
		   $form = array_pop($created);
			$formId = $form->id();
			$name = $form->name();
			$status = $form->state();
			$anon = $form->anon();

			if($status == TRUE){
				$link = "results.php?form=$formId";
			}else{
				$link = "createform.php?form_id=$formId";
			}
?>
							<tr class="info">
								<td><a href="<?php echo $link ?>"><?php echo $name ?></a></td>
								<?php
									if($status == TRUE){

										if($anon == TRUE){
											$content = $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], "/"));
											$formdestId = $form->formdestId(0, 0);
											$link = "/fillform.php?form_id=$formId&formdest_id=$formdestId&prev_id=0";
											$content .= $link;
										}
								?>
								<td>
								   <?php
										if($anon == TRUE){
									?>
									  <button type='button' class='btn btn-primary' data-toggle='popover' data-title='A copier' data-content='<?php echo $content ?>'>URL</button>                    <?php
										}
									?>
								</td>
								<td>Publié</td>
								<?php
									}else{
								?>
								<td>
									<a href="include/deleteform.php?form_id=<?php echo $formId ?>" class="text-muted">
										<span class="glyphicon glyphicon-trash" aria-hidden="true" onclick="return confirm('Voulez-vous vraiment supprimer ?');"></span>
									</a>
								</td>
								<td>Enregistré</td>
								<?php
									}
								?>
							</tr>
<?php
		}
?>
						</tbody>
					</table>
<?php
	}
?>
				</div>
			</div>
			
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading text-center text-capitalize">
						<h3 class="panel-title">
							<strong>Boîte de réception</strong>
						</h3>
					</div>
<?php
	if(count($recipient) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<th>Nom</th>
								<th>Archives</th>
							</tr>
						</thead>
						<tbody>
<?php
      for($nb = 0; $nb < 3 && count($recipient) > 0; $nb++) {
		   $form = array_pop($recipient);
			$id = $form->id();
			$name = $form->name();
			$status = $form->state();
?>
							<tr class="info">
								<td><a href="form.php?form=<?php echo $id ?>"><?php echo $name ?></a></td>
								<td><a href="formarchive.php?form=<?php echo $id ?>">Aller</a></td>
							</tr>
<?php
		}
?>
						</tbody>
					</table>
<?php
	}
?>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
</body>
</html>
