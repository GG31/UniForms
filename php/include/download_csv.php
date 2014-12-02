<?php
if (isset ( $_GET ["form_id"] ) and isset ( $_GET ["user_id"] )) {
	include_once ('includes.php');
	
	$user = new User ( $_GET ["user_id"] );
	
	$form = new Form ( $_GET ["form_id"] );
	$ans = $form->getAnswer ( [ ], 1 );
	
	// la variable qui va contenir les données CSV
	$outputCsv = '';
	
	// Nom du fichier final
	$fileName = "Form_" . $_GET ["form_id"] . "Answers";
	$fileName .= date ( 'Y-m-d_H:i:s' );
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
	$outputCsv .= "Exemple Simple d'exportation des donnees";
	// Entêtes (headers) PHP qui vont bien pour la création d'un fichier Excel CSV
	header ( "Content-disposition: attachment; filename=" . $fileName );
	header ( "Content-Type: application/force-download" );
	header ( "Content-Transfer-Encoding: application/vnd.ms-excel\n" );
	header ( "Pragma: no-cache" );
	header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0, public" );
	header ( "Expires: 0" );
	
	echo $outputCsv;
	exit ();
}
?>