<?

class user {
	public $userId;
	
	function __construct($id) { 
		$this->$userId = $id;
    } 
	
	// Returns all forms that the user is the creator.
	function getCreatedForms(){
		$query = mysql_query($connection, "SELECT * FROM form WHERE user_id = ".$this->$userId);
	}
	
	// Returns all forms that the user is the destinator
	function getDestForms(){
		$query = mysql_query($connection, "SELECT * FROM form_dest WHERE user_id = ".$this->$userId);
	}
	
	// Returns all users
	function static getAllUsers(){
		$query = mysql_query($connection, "SELECT * FROM users");
	}
	
}

?>