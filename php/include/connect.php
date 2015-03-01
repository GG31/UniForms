<?php
/*
$connection = mysql_connect ( "localhost", "root", "" ) or die ( mysql_error () );
$database = mysql_select_db ( "uniforms" ) or die ( mysql_error () );
*/
global $database;
$database = mysqli_connect('localhost', 'root', 'root', 'uniforms');
?>
