<div class="row">
	<nav class="navbar navbar-default col-sm-offset-2 col-sm-8" role="navigation">
		<div class="container-fluid">

			<div class="navbar-header">
				<a class="navbar-brand" href="home.php">UniForms</a>
			</div>

			<ul class="nav navbar-nav">
				<li>
					<a href="createform.php">Créer un formulaire</a>
				</li>
				<!--<li>
					<a href="#">Link</a>
				</li>-->
			</ul>
			
			<ul class="nav navbar-nav">
				<li>
					<a href="archive_forms.php">Mes Archives</a>
				</li>
			</ul>

			<!--<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>-->

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><?php echo $_SESSION["user_name"];?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<!--<li>
							<a href="#">Action</a>
						</li>
						<li>
							<a href="#">Another action</a>
						</li>
						<li>
							<a href="#">Something else here</a>
						</li>
						<li class="divider"></li>-->
						<li>
							<a href="include/logout.php">Logout</a>
						</li>
					</ul>
				</li>
			</ul>
		</div><!-- /.container-fluid -->
	</nav>
</div>