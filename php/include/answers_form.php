<?php
	if(isset($_GET["user_id"])){
?>
<?php
	include_once('class/DBSingleton.class.php');
	DBSingleton::getInstance();
	include_once("class/Form.class.php");

	$form = new Form($_GET["form_id"]);

	$dest = $form->getAllFormReceivers(1);
	$prev = -1;
	$next = -1;
	while($line = mysql_fetch_array($dest)){
		if($line["user_id"] == $_GET["user_id"]){
			$next = mysql_fetch_array($dest)["user_id"];
		}else{
			$prev = $line["user_id"];
		}
	}
	if($next == NULL)
		$next = -1;
?>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $_GET["user_id"] ?></div>
		<div class="panel-body">
			Bla
		</div>
	</div>
</div>
<div class="row">
	<nav>
		<ul class="pager">
			<?php
				if($prev == -1){
			?>
					<li class="disabled"><a href="">&larr; Previous</a></li>
			<?php
				}else{
			?>
					<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $prev ?>">&larr; Previous</a></li>
			<?php
				}
			?>
			<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>">&uarr; Back &uarr;</a></li>
			<?php
				if($next == -1){
			?>
					<li class="disabled"><a href="">Next &rarr;</a></li>
			<?php
				}else{
			?>
					<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $next ?>">Next &rarr;</a></li>
			<?php
				}
			?>
		</ul>
	</nav>
</div>

<?php
	}
?>