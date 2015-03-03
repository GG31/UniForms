<?php
	include_once 'include/includes.php';

	if(!isset($_GET["form"]))
		return;

	$formId = $_GET["form"];
	$form = new Form($formId);
	$groups = $form->groups();
	$last = count($groups) - 1;
	$users = $groups[$last]->users();
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
							<strong><?php echo $form->name();?></strong>
							<br>
							<a href="include/download_csv.php?form=<?php echo $formId ?>" style="text-decoration:none">CSV
								<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>
							</a>
							<a href="include/exportSQL.php?form_id=<?php echo $formId ?>" style="text-decoration:none">SQL
								<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>
							</a>
						</h3>
					</div>
<?php
	foreach ($users as $user) {
		$tree = $form->tree($user->id(), TRUE, [$last])[$last];

		foreach($tree as $prev => $answers){
			unset($answers["left"]);

			// Don't display table if left == 0 and there is no answers to validate
			if(count($answers) != 0){
?>
					<table class="table table-hover">
						<thead>
							<tr class="success">
								<th>
								<?php
									$chain = $form->chain($prev);
									unset($chain[0]);
									foreach($chain as $userId){
										$name = (new User($userId))->name();
										echo $name . " -> ";
									}
									echo $user->name();
								?>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
<?php
				foreach($answers as $key => $answer){
					$ansId = $answer->id();
					$link = "formresult.php?ans_id=$ansId";
?>
							<tr class="info">
								<td><a href="<?php echo $link ?>">Réponse #<?php echo $key ?></a></td>
								<td>
									<a
										href="include/download_csv.php?ans=<?php echo $ansId ?>"
										data-toggle="popover"
										data-trigger="hover"
										data-title="Télécharger"
										data-content="Télécharger cette réponse au format CSV"
										>
										<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>
									</a>
								</td>
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