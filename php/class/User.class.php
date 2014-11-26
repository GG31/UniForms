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
		return mysql_query("SELECT * FROM user");
	}
	
	// "Enregistrer" one form. (the idForm must be 0 if the form don't exists yet). Create/update a form with the status "enregistrer". Returns an object form.
	public function enregistrerForm($idForm = 0){
		return $this->saveForm($idForm, 0);
	}
	
	// "Valider" one form. (the idForm must be 0 if the form don't exists yet). Create/update a form with the status "valider". Returns an object form.
	public function validerForm($idForm = 0){
		return $this->saveForm($idForm, 1);
	}
	
	// Update or create a new form with status $status. And returns the form object that corresponds to it.
	private function saveForm($idForm = 0, $status){
		if ($idForm==0){
			mysql_query("INSERT INTO form(user_id, status) VALUES (".$this->userId.", ".$status.")") or die('SQL Error<br>'.mysql_error());
			$idForm = mysql_insert_id();
		}else{
			mysql_query("UPDATE form SET status = ".$status." WHERE form_id = ".$idForm) or die('SQL Error<br>'.mysql_error());
		}
		$newForm = new form($idForm);
		return $newForm;
	}
}
?>