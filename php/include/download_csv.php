<?php
if (isset ( $_GET ["ans_id"] )) {
	include_once ('includes.php');
	
	$answer = new Answer($_GET ["ans_id"]);
	$recipient = $answer->getRecipient();
	$idform = $answer->getFormId();
	$form = new Form($idform);
	$ans = $form->getListRecipient ( [ ], 1 );
	//var_dump($ans);
	foreach ( $ans as $key => $value ) {
			echo "formDest : ".$value["Answer"]->getId()."<br/>";
	}
	
	// la variable qui va contenir les données CSV
	/*$outputCsv = '';
	
	// Nom du fichier final
	//$fileName = "Form_" . $_GET ["form_id"] . "Answers";
	$fileName = "Form_Results";
	//$fileName .= date ( 'Y-m-d_H:i:s' );
	$fileName .= ".csv";
	/*
	 * foreach ($ans as $clef => $valeur) {
	 * //$outputCsv .= trim($valeur) . ';';
	 *
	 * // Suppression du ; qui traine à la fin
	 * // $outputCsv = rtrim($outputCsv, ';');
	 *
	 * // Saut de ligne
	 * $outputCsv .= "\n";
	 * }
	 */
	/*$outputCsv .= "Exemple Simple d'exportation des donnees";
	$outputCsv .= "<br/><br/>";
	// Entêtes (headers) PHP qui vont bien pour la création d'un fichier Excel CSV
	header ( "Content-disposition: attachment; filename=" . $fileName );
	header ( "Content-Type: application/force-download" );
	header ( "Content-Transfer-Encoding: application/vnd.ms-excel\n" );
	header ( "Pragma: no-cache" );
	header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0, public" );
	header ( "Expires: 0" );
	
	echo $outputCsv;
	exit ();*/
}
?>