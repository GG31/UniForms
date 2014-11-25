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
	public function __construct($id) {
		$this->$form_id = $id;
	}
	
	public static function getLastId(){
		$query = mysql_query($connection, "SELECT form_id FROM form ORDER BY form_id DESC  LIMIT 1")
			or die('Erreur SQL !'.$query.'<br>'.mysql_error());
	}
	
	public static function getAll() {
		$query = mysql_query($connection, "SELECT * FROM form", $connection)
			or die('Erreur SQL !'.$query.'<br>'.mysql_error());
	}
	
	public static function  putForm($creator_id, $form_id, $dest_id, $etat){
		$query = mysql_query($connection, "INSERT INTO form(form_id, user_id, etat) VALUES ('', '$creator_id', 'Enregistrer')", $connection)
			or die('Erreur SQL !'.$query.'<br>'.mysql_error());
		$form = mysql_insert_id();
		$query = mysql_query($connection, "INSERT INTO formdest (formdest_id, form_id, user_id, etat) VALUES ('', '$form', '$creator_id', 'Enregistrer')", $connection)
			or die('Erreur SQL !'.$query.'<br>'.mysql_error());
	}
}
?>