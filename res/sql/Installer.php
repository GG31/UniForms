<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../../res/img/favicon.png" />
<link rel="stylesheet" href="../../lib/bootstrap-3.3.1/css/min.css"
	type="text/css" />
<link rel="stylesheet" href="../../css/styles.css" type="text/css" />
</head>
<body>
	<div class="container">
			<?php include '../../php/include/header.php'; ?>
			<form class="form-horizontal panel panel-primary" role="form"
			action="Installer.php" method="post">
			<!-- No need for .row with .form-horizontal-->
			<div class="panel-heading text-center">
				<div class="panel-title">
					<strong>Database installer</strong>
				</div>
			</div>
			
			<div class="panel-body">
				<div class="form-group">
					<label for="login" class="col-sm-4 control-label">Server</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="server" name="server"
							placeholder="localhost">
					</div>
				</div>
				
				<div class="form-group">
					<label for="login" class="col-sm-4 control-label">Username</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username"
							placeholder="root">
					</div>
				</div>
				
				<div class="form-group">
					<label for="password" class="col-sm-4 control-label">Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="password"
							name="password" placeholder="password">
					</div>
				</div>
								
			</div>
			
			<div class="panel-footer">
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-10">
						<button type="submit" class="btn btn-default">Install</button>
					</div>
				</div>
			</div>
		</form>
			<?php include '../../php/include/footer.php'; ?>
		</div>
		<?php
		if(!empty($_POST)){
			$server = $_POST['server'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			global $db;
			$db = mysqli_connect ( $server, $username, $password );
			$sql = "DROP DATABASE IF EXISTS uniforms;";
			mysqli_query ($database, $sql ) or die ( mysql_error () );
			
			$sql = "CREATE DATABASE IF NOT EXISTS uniforms;";
			mysqli_query ($database, $sql ) or die ( mysql_error () );
			
			$sql = "USE uniforms;";
			mysqli_query ($database, $sql ) or die ( mysql_error () );
			
			$fich = fopen ( 'uniforms.sql', "r+" );
			$lig = "";
			while ( ! feof ( $fich ) )
				$lig .= fgets ( $fich );
			$req = explode ( ";", $lig );
			foreach ( $req as $lii ) {
				mysqli_query ( $lii );
			}
			fclose ( $fich );
			
			header ( "Location:../../" );
		}
		?>
	</body>
</html>
