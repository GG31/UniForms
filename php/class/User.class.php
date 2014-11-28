<?php
class User {
	// User id (user_id)
	private $id;
	// User name
	private $name;

    /*
    	Constructor
     */	
	function __construct($userId) {
		$this->id = $userId;
    }

    /*
    	getId
    	Returns user's id
     */
	public function getId(){
		return $this->id;
	}

    /*
    	getName
    	Returns user's name
     */
	public function getName(){
		return $this->name;
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
	public function getCreatedForms(){
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
	public function getDestinatairesForms(){
	   $q = mysql_query("SELECT formdest.form_id FROM formdest, form WHERE formdest.form_id=form.form_id AND formdest.user_id=".$this->id." AND form_status=1");
		$res = [];
		while($line = mysql_fetch_array($q)){
		   $res[] = new Form($line["form_id"]);
		}
		return $res;
	}

	/*
		isCreator(int formId)
		Returns TRUE (FALSE) if user is (not) creator of form
	 */
	public function isCreator($formId){
		$f = new Form($formId);
		if($f->getCreator()->getId() == $this->id)
			return TRUE;
		else
			return FALSE;
	}

	/*
		isDest(int formID)
		Returns TRUE (FALSE) if form is (not) destinated to user
	 */
	public function isDestinataire($formID){
		$f = new Form($formId);
		$d = $f->getRecipient();
		foreach($d as $dest){
			if($dest->id == $this->id)
				return TRUE;
		}
		return FALSE;
	}
}
?>
