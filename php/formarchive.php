<?php
	include_once 'include/includes.php';

	if(!isset($_GET["form"]) && !isset($_SESSION["user_id"]))
		return;

	$formId = $_GET["form"];
	$userId = $_SESSION["user_id"];

	$form = new Form($formId);
	$tree = $form->tree($userId, TRUE);
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
	foreach($tree as $groupNum => $group){
		foreach($group as $prev => $answers){
			$left = $answers["left"];
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
									foreach($chain as $key => $userId){
										$name = (new User($userId))->name();
										$sep = "";
										switch ($key) {
											case 0:
												$sep = " : ";
												break;
											case count($chain) - 1:
												break;
											default:
												$sep = " -> ";
												break;
										}
										echo $name . $sep;
									}
								?>
								</th>
							</tr>
						</thead>
						<tbody>
<?php
				foreach($answers as $key => $answer){
					$ansId = $answer->id();
					$link = "fillform.php?ans_id=$ansId";
?>
							<tr class="info">
								<td><a href="<?php echo $link ?>">Réponse #<?php echo $key ?></a></td>
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
?>
				</div>
			</div>
			<?php include 'include/footer.php'; ?>
		</div>
	</body>
</html>