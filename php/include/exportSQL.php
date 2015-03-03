<?php
include_once ('includes.php');
if (isset($_GET["form_id"])) {
	$form = new Form($_GET["form_id"]);
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