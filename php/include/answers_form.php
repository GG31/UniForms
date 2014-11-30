<?php
	if(isset($_GET["form_id"]) AND isset($_GET["user_id"])){
		include_once('include/includes.php');

		$form = new Form($_GET["form_id"]);
		$ans = $form->getAnswer([], 1);

		$prev = NULL;
		$next = NULL;
		foreach ($ans as $key => $a) {
			if($a->getUser()->getId() == $_GET["user_id"]){
				if($key + 1 < count($dest))
					$next = $ans[$key + 1]->getUser();
				break;
			}else
				$prev = $a->getUser();
		}
?>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $_GET["user_id"] ?></div>
		<div class="panel-body">
		</div>
	</div>
</div>
<div class="row">
	<nav>
		<ul class="pager">
			<?php
				if(!$prev){
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
				if(!$next){
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