<?php
	if(isset($_GET["user_id"])){
?>
<?php

	include_once('class/DBSingleton.class.php');
	DBSingleton::getInstance();
	include_once("class/Form.class.php");

	$form = new Form($_GET["form_id"]);
	$dest = $form->getAllFormsReceivers();
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
			<li class="disabled"><a href="#">&larr; Previous</a></li><!-- TODO -->
			<li><a href="answers.php?form_id<?php echo $_GET["form_id"] ?>">&uarr; Back &uarr;</a></li>
			<li><a href="#">Next &rarr;</a></li><!-- TODO -->
		</ul>
	</nav>
</div>

<?php
	}
?>