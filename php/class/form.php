<?php 
/**
 * @author BENATHMANE
 *
 */
class form {

	// Attributs
	public $formId;
	
	// Méthodes 
	public function __construct($id) {
		$this->formId = $id;
	}
	
	public static function getAll() {
		return mysql_query($connection, "SELECT * FROM form") or die('SQL Error<br>'.mysql_error());
	}
	
	// Save all elements of listDest in the table form_dest
	public function addDest($listDest = array()){
		mysql_query("DELETE FROM form_dest WHERE user_id = ".$this->formId);
		foreach ($listDest as $Dest){
			mysql_query("INSERT INTO form_dest(user_id, status) VALUES (".$this->$userId.", ".$status".)") or die('SQL Error<br>'.mysql_error());
		}
	}
	
	
}
?>