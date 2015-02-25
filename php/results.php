<?php
	include_once 'include/includes.php';

	if(!isset($_GET["form"]))
		return;

	$formId = $_GET["form"];
	$form = new Form($formId);
	$groups = $form->groups();
	$num = count($groups) - 1;
	$users = $groups[$num]->users();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UniForms</title>
		<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
			type="text/css" />
		<link rel="stylesheet" href="../css/styles.css" type="text/css" />

		<script src="../lib/jquery-2.1.1/min.js"></script>
		<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
	</head>
	<body>
		<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading text-center text-capitalize">
						<h3 class="panel-title">
							<strong><?php echo $form->name();?></strong>
						</h3>
					</div>
<?php
	foreach ($users as $user) {
		$tree = $form->tree($user->id(), TRUE, [$num]);

		foreach($tree as $groupNum => $group){
			foreach($group as $prev => $answers){
				unset($answers["left"]);

				// Don't display table if left == 0 and there is no answers to validate
				if(count($answers) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<!-- <th>Group <?php echo $groupNum ?></th> -->
								<th>
								<?php
									$chain = $form->chain($prev);
									unset($chain[0]);
									foreach($chain as $key => $userId){
										$name = (new User($userId))->name();
										echo $name . " -> ";
									}
									echo $user->name();
								?>
								</th>
							</tr>
						</thead>
						<tbody>
<?php
					foreach($answers as $key => $answer){
?>
							<tr class="info">
								<td><a href="#">Réponse #<?php echo $key ?></a></td>
							</tr>
<?php
					}
?>
						</tbody>
					</table>
<?php
				}
			}
		}
	}
?>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>