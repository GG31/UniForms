<?php 
/**
 * @author BENATHMANE
 *
 */
class Form {

	// Attributs
	public $form_id;
	
	// Constantes
	
	// Méthodes 
	public function __construct() { }
	
	public static function getLastId(){
		$query = mysql_query("SELECT form_id FROM form ORDER BY form_id DESC  LIMIT 1");
	}
	
	public static function getAll() {
		$query = mysql_query("SELECT * FROM form");
	}
}
?>