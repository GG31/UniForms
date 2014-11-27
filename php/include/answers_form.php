<?php
	if(isset($_GET["user_id"])){
?>
<?php
	include_once('include/includes.php');

	$form = new Form($_GET["form_id"]);
	$dest = $form->getRecipient();

	$prev = -1;
	$next = -1;
	foreach($dest as $key => $d){
		if($d->getId() == $_GET["user_id"]){
			$next = $dest[$key + 1];
			break;
		}
		else
			$prev = $d;
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
					<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $prev->getId() ?>">&larr; Previous</a></li>
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
					<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $next->getId() ?>">Next &rarr;</a></li>
			<?php
				}
			?>
		</ul>
	</nav>
</div>

<?php
	}
?>