<footer class="row well">
	<div class="col-sm-4">UniForms</div>
	<div class="col-sm-4">
		BENATHMANE Ayoub, benathmane.ab@gmail.com <br> TRUCHI Romain,
		romain.truchi.06@gmail.com <br> POLO Luís Felipe,
		luisfelipepolo@hotmail.com <br> CIRERA Geneviève,
		genevieve.cirera@gmail.com
	</div>
	<div class="col-sm-4">© 2014-2015<br/>
	<?php 
		$content = $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], "/"));
		$content = str_replace("/php", "", $content);
	?>
		<a href="<?php echo "http://".$content."/doc/userManual/UserManual.html";?>" style="text-decoration:none">
			<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
			Manuel d'utilisation
		</a>
	</div>
</footer>
