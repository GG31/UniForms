<?

class user {
	public $userId;
	
	
	function __construct($id) { 
		$this->$userId;
    } 
	
	// Returns all forms that the user is the creator.
	function getCreatedForms(){
		$query = mysql_query("SELECT * FROM form WHERE user_id = ".$this->$userId);
	}
	
	// Returns all forms that the user is the destinator
	function getDestForms(){
		$query = mysql_query("SELECT * FROM form_dest WHERE user_id = ".$this->$userId);
	}
	
	// Returns all users
	function getAllUsers(){
		$query = mysql_query("SELECT * FROM users");
	}
	
}

?>
