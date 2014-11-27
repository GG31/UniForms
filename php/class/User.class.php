<?php
class User {

	public $userId;
	
	// Constructor
	function __construct($id) {
		$this->userId = $id;
    }
	
	// Returns registers which represent forms that user is the creator.
	public function getCreatedForms(){
		return mysql_query("SELECT * FROM form WHERE user_id = ".$this->userId);
	}
	
	// Returns registers which represent forms that user is the destinator
	public function getDestForms(){
		return mysql_query("SELECT * FROM formdest WHERE user_id = ".$this->userId);
	}
	
	// Returns registers of all users
	public static function getAllUsers(){
		mysql_query("SET NAMES 'utf8'");
		return mysql_query("SELECT * FROM user");
	}
	
	// Create a new form (with status "not send") and returns the form object that corresponds to it.
	public function createForm(){
		mysql_query("INSERT INTO form(user_id, status) VALUES (".$this->userId.", 0)") or die('SQL Error<br>'.mysql_error());
		$idForm = mysql_insert_id();
		$newForm = new form($idForm);
		return $newForm;
	}
}
?>