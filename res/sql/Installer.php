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
				
				<div class="form-group">
					<label for="database" class="col-sm-4 control-label">Database name</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="dbname"
							name="dbname" placeholder="uniforms">
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
			$conn = mysqli_connect($_POST['server'], $_POST['username'], $_POST['password']);
			if (!mysqli_connect_error()){
				$contenu = "<?php global \$database;  \$database = mysqli_connect('serverdb', 'userdb', 'passworddb', 'databasedb') ?>";
				echo $contenu;	
				$s1 =  $_POST["server"];
				$ss1 = "$s1";
				$contenuMod = str_replace('serverdb', $ss1, $contenu);
					
				$s2 =  $_POST["username"];
				$ss2 = "$s2";
				$contenuMod = str_replace('userdb', $ss2, $contenuMod );
					
				$s3 =  $_POST["password"];
				$ss3 = "$s3";
				$contenuMod = str_replace('passworddb', $ss3, $contenuMod);
					
				$s4 =  $_POST["dbname"];
				$ss4 = "$s4";
				$contenuMod = str_replace('databasedb', $ss4, $contenuMod);
					
				//ouverture en écriture
				$monfichier2=fopen('../../php/include/connect.php','w+') or die("Fichier manquant");
				fwrite($monfichier2,$contenuMod);
				fclose($monfichier2);
				
				mysqli_connect ( $server, $username, $password );
				$sql = "DROP DATABASE IF EXISTS ".$_POST['dbname'].";";
				mysqli_query ($conn, $sql ) or die ( mysqli_error ($conn) );
				
				$sql = "CREATE DATABASE IF NOT EXISTS ".$_POST['dbname'].";";
				mysqli_query ($conn,  $sql ) or die ( mysqli_error ($conn) );
				
				$sql = "USE ".$_POST['dbname'].";";
				mysqli_query ($conn, $sql ) or die ( mysqli_error ($conn) );
				
				$fich = fopen ( 'uniforms.sql', "r+" );
				$lig = "";
				while ( ! feof ( $fich ) )
					$lig .= fgets ( $fich );
				$req = explode ( ";", $lig );
				foreach ( $req as $lii ) {
					mysqli_query ($conn, $lii );
				}
				fclose ( $fich );
				
				header ( "Location:../../" );
			}else{
				header ( "Location:error.php" );
			}
		}
		?>
	</body>
</html>