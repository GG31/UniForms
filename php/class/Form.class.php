<?php
class Form {
	// Form id (form_id)
	private $id;
	// Form creator
	private $creator;
	// Form dest list
	private $dest;
	// Form answers list
	private $ans;
	// Form status
	private $state;
	
	/*
		Constructor
		TODO
	 */
	public function __construct() {
		switch(func_num_args()){
            case 1: // new Form();
                break;
            case 2: // new Form(id);
                $this->id = func_get_arg(0));

				$q = mysql_query("SELECT user_id, status FROM form WHERE form_id = " . $this->id);
				$line = mysql_fetch_array($q);
				$this->creator = new User($line["user_id"]);
				$this->state = $line["status"] == 1 ? TRUE : FALSE;

				$q = mysql_query("SELECT user_id, formans_id FROM formdest JOIN formans ON formdest.formdest_id = formans.formdest_id AND formdest.form_id = " . $this->id);
				$this->dest = [];
				$this->ans = [];
				while($line = mysql_fetch_array($q)){
					$this->dest[] = new User($line["user_id"]);
					$this->ans[] = new Answer($line["formans_id"]);
				}
                break;
        }
	}

	/*
		id
		Returns form's id
	 */
	public function id(){
		return $this->id;
	}

	/*
		state
		Returns form's status
	 */
	public function state(){
		return $this->state;
	}

	/*
		getCreator
		Returns form's creator
	 */
	public function getCreator(){
		return $this->creator;
	}

	/*
		getDest
		Returns form's dest list
	 */
	public function getDest(){
		return $this->dest;
	}

	/*
		getAns
		Returns form's answers list
	 */
	public function getAns(){
		return $this->ans;
	}

	/*
		setCreator
		Sets form's creator
	 */
	public function setCreator($user){
		$this->creator = $user;
	}

	/*
		setDest
		Sets form's dest list
	 */
	public function setDest($destList){
		$this->dest = $destList;
	}

	/*
		save
		TODO verif attr!=NULL
	 */
	public function save(){
		// Clean
		mysql_query("DELETE FROM formdest WHERE form_id = ".$this->id);
		// Insert dest
		foreach ($this->dest as $d){
			mysql_query("INSERT INTO formdest(form_id, user_id, status) VALUES (".$this->id.",".$d->id().", 0)") or die('SQL Error<br>'.mysql_error());
		}
	}

	/*
		send
	 */
	public function send(){
		save();
		$this->state = TRUE;
		// Update status
		mysql_query("UPDATE form SET status = 1 WHERE form_id = ".$this->id);
	}







	// ------------------------

	// Returns all forms receivers
	// Status = -1 : Returns all receivers
	//		  =  0 : Returns all receivers that didn't answered form yet.
	//        =  1 : Returns all receivers that already had answered the form.
	public function getAllFormReceivers($status = -1) {
		$sql = "SELECT * FROM user JOIN formdest ON user.user_id = formdest.user_id AND formdest.form_id = ".$this->formId;
		if ($status != -1)
			$sql .= " AND status = ".$status;
		$sql .= " ORDER BY user.user_id";
		return mysql_query($sql);
	}
	
	// Returns all forms
	public static function getAllForms() {
		return mysql_query("SELECT * FROM form");
	}
	
	// Send the form to all his receivers
	public function validateForm(){
		mysql_query("UPDATE form SET status = 1 FROM form WHERE form_id = ".$this->id);
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