<?php
if (isset ( $_GET ["form_id"] ) and isset ( $_GET ["user_id"] )) {
	include_once ('include/includes.php');
	
	$user = new User ( $_GET ["user_id"] );
	
	$form = new Form ( $_GET ["form_id"] );
	$ans = $form->getAnswer ( [ ], 1 );
	
	$prev = NULL;
	$next = NULL;
	foreach ( $ans as $key => $a ) {
		if ($a->getUser ()->getId () == $_GET ["user_id"]) {
			if ($key + 1 < count ( $ans ))
				$next = $ans [$key + 1]->getUser ();
			break;
		} else {
			$prev = $a->getUser ();
		}
	}
	?>
<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading text-center text-capitalize">
			<strong><?php echo $user->getName() ?></strong>
		</div>
		<div class="panel-body"></div>
	</div>
</div>
<div class="row">
	<nav>
		<ul class="pager">
			<?php
	if (! $prev) {
		?>
					<li class="disabled"><a href="">&larr; Previous</a></li>
			<?php
	} else {
		?>
					<li><a
				href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $prev->getId() ?>">&larr;
					Previous</a></li>
			<?php
	}
	?>
			<li><a href="answers.php?form_id=<?php echo $_GET["form_id"] ?>">&uarr;
					Back &uarr;</a></li>
			<?php
	if (! $next) {
		?>
					<li class="disabled"><a href="">Next &rarr;</a></li>
			<?php
	} else {
		?>
					<li><a
				href="answers.php?form_id=<?php echo $_GET["form_id"] ?>&user_id=<?php echo $next->getId() ?>">Next
					&rarr;</a></li>
			<?php
	}
	?>
		</ul>
	</nav>
</div>
<?php
	}
?>