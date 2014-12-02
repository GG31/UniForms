<?php
mysql_pconnect ( "localhost", "root", "" );
// mysql_pconnect ( "localhost", "root", "root" );
$sql = "DROP DATABASE IF EXISTS uniforms;";
mysql_query ( $sql ) or die ( mysql_error () );

$sql = "CREATE DATABASE IF NOT EXISTS uniforms;";
mysql_query ( $sql ) or die ( mysql_error () );

$sql = "USE uniforms;";
mysql_query ( $sql ) or die ( mysql_error () );

$fich = fopen ( 'uniforms.sql', "r+" );
$lig = "";
while ( ! feof ( $fich ) )
	$lig .= fgets ( $fich );
$req = explode ( ";", $lig );
foreach ( $req as $lii ) {
	mysql_query ( $lii );
}
fclose ( $fich );

session_start ();
session_destroy ();
header ( "Location:../../" );

?>
