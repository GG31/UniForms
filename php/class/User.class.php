<?php
class User {
	// User id (user_id)
	private $id;

    /*
    	Constructor
    	TODO
     */	
	function __construct($userId) {
		$this->id = $userId;
    }

    /*
    	id
    	Returns user's id
     */
	public function id(){
		return $this->id;
	}

    /*
    	all
    	Returns array of all users
     */
	public static function all(){
		$q = mysql_query("SELECT user_id FROM user");
		$res = [];
		while($line = mysql_fetch_array($q)){
			$res[] = new User($line["user_id"]);
		}
		return $res;
	}

	/*
		getCreated
		Returns list of forms created by user
	 */
	public function getCreated(){
		$q = mysql_query("SELECT form_id FROM form WHERE user_id = ".$this->id);
		$res = [];
		while($line = mysql_fetch_array($q)){
			$res[] = new Form($line["form_id"]);
		}
		return $res;

	}

	/*
		getDest
		Returns list of forms destinated to user
	 */
	public function getDest(){
		$q = mysql_query("SELECT form_id FROM formdest WHERE user_id = ".$this->userId);
		$res = [];
		while($line = mysql_fetch_array($q)){
			$res[] = new Form($line["form_id"]);
		}
		return $res;
	}

	/*
		isCreator(int formID)
		Returns TRUE (FALSE) if user is (not) creator of form
	 */
	public function isCreator($formID){
		$f = new Form($formId);
		if($f.getCreator().id() == $this.id)
			return TRUE;
		else
			return FALSE;
	}

	/*
		isDest(int formID)
		Returns TRUE (FALSE) if form is (not) destinated to user
	 */
	public function isDest($formID){
		$f = new Form($formId);
		$d = $f.getDest();
		foreach($d as $dest){
			if($dest.getDest().id() == $this.id)
				return TRUE;
		}
		return FALSE;
	}

	// -----------------------

	// Create a new form (with status "not send") and returns the form object that corresponds to it.
	public function createForm(){
		mysql_query("INSERT INTO form(user_id, status) VALUES (".$this->userId.", 0)") or die('SQL Error<br>'.mysql_error());
		$idForm = mysql_insert_id();
		$newForm = new form($idForm);
		return $newForm;
	}
}
?>