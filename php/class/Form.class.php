<?php
class Form {

	public $formId;
	
	// Constructor 
	public function __construct($id) {
		$this->formId = $id;
	}

	// Returns all forms receivers
	// Status = -1 : Returns all receivers
	//		  =  0 : Returns all receivers that didn't answered form yet.
	//        =  1 : Returns all receivers that already had answered the form.
	public function getAllFormReceivers($status = -1) {
		$sql = "SELECT * FROM user JOIN formdest ON user.user_id = formdest.user_id AND formdest.form_id = ".$this->formId." ORDER BY user.user_id";
		if ($status != -1)
			$sql .= " AND status = ".$status;
		return mysql_query($sql);
	}
	
	// Returns all forms
	public static function getAllForms() {
		return mysql_query("SELECT * FROM form");
	}
	
	// Send the form to all his receivers
	public function validateForm(){
		mysql_query("UPDATE status FROM form WHERE form_id = ".$this->formId);
		$this->sendLink();
	}
	
	// Send e-mail with link to form to all his receivers
	public function sendLink(){
		$qReceivers = getAllFormReceivers();
		if (mysql_num_rows($qReceivers)){
			while($Receiver = mysql_fetch_array($qReceivers)){
				//mail();
			}
		}
	}
	
	// $listDest must be a list of IDs of all the receivers. Save all elements of listDest in the table form_dest.
	public function addDest($listDest = array()){
		mysql_query("DELETE FROM formdest WHERE form_id = ".$this->formId);
		foreach ($listDest as $destId){
			mysql_query("INSERT INTO formdest(form_id, user_id, status) VALUES (".$this->formId.",".$destId.", 0)") or die('SQL Error<br>'.mysql_error());
		}
	}
}
?>