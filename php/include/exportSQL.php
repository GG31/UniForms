<?php
include_once ('includes.php');
if (isset($_GET["form"])) {
	$form = new Form($_GET["form"]);
	if ($form->creator()->id() == $_SESSION["user_id"]){
		$fileName = "exportedform.sql";
		/*$file = fopen($fileName, "c");
		fwrite($file, $form->exportSQL());
		fclose($file);*/
		header ( "Content-disposition: attachment; filename=" . $fileName );
		header ( "Content-Type: application/octet-stream" );
		header ( "Pragma: no-cache" );
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0, public" );
		header ( "Expires: 0" );
		//readfile($fileName);
		echo $form->exportSQL();
		exit ();
	}
}
?>