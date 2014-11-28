<?php
class Form {
	// Form id (form_id)
	private $id;
	// Form creator
	private $creator;
	// Form dest list
	private $recipient;
	// Form answers list
	private $ans;
	// Form status
	private $state = 0;
	
	/*
		Constructor
	 */
	public function __construct() {
		switch(func_num_args()){
            case 0: // new Form();
                break;
            case 1: // new Form(id);
               $this->id = func_get_arg(0);

			      $q = mysql_query("SELECT user_id, status FROM form WHERE form_id = " . $this->id);
			      $line = mysql_fetch_array($q);
			      $this->creator = new User($line["user_id"]);
			      $this->state = $line["status"] == 1 ? TRUE : FALSE;

				   $q = mysql_query("SELECT user_id, status FROM formdest WHERE form_id = " . $this->id . " ORDER BY user_id");
				   $this->recipient = [];
				   while($line = mysql_fetch_array($q)){
					   $this->recipient[new User($line["user_id"])] = $line["status"];
				   }

				   $q = mysql_query("SELECT formans_id FROM formdest JOIN formans ON formdest.formdest_id = formans.formdest_id AND formdest.form_id = " . $this->id);
				   $this->ans = [];
				   while($line = mysql_fetch_array($q)){
					   $this->ans[] = new Answer($line["formans_id"]);
				   }
               break;
            default:
            	break;
        }
	}

	/*
		id
		Returns form's id
	 */
	public function getId(){
		return $this->id;
	}

	/*
		state
		Returns form's status
	 */
	public function getState(){
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
		getRecipient
		Returns form's dest list
	 */
	public function getRecipient(){
		return $this->recipient;
	}

	/*
		getAns
		Returns form's answers list
	 */
	public function getAnswer(){
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
		setRecipient
		Sets form's dest list
	 */
	public function setRecipient($recipientList){
		$this->recipient = $recipientList;
		var_dump($this->recipient);
	}
	
	public function setState($state){
		$this->state = $state;
	}

	/*
		save
		TODO verif attr!=NULL
	 */
	public function save(){
		// Clean
		mysql_query("DELETE FROM form WHERE form_id = ".$this->id);
		$exist = mysql_query("SELECT form_id FROM form WHERE form_id = ".$this->id);
		if(!$exist) {
		   mysql_query("INSERT INTO form(user_id, status) VALUES (".$this->creator->getId().", ".$this->state.")");
		   $this->id = mysql_insert_id();
		}
		// Insert dest
		foreach ($this->recipient as $d){
			mysql_query("INSERT INTO formdest(form_id, user_id, status) VALUES (".$this->id.",".$d->getId().", 0)") or die('SQL Error<br>'.mysql_error());
		}
	}

	/*
		send
	 */
	public function send(){
		$this->save();
		$this->state = TRUE;
		// Update status
		mysql_query("UPDATE form SET status = 1 WHERE form_id = ".$this->id);
	}
	
	public function getStateOf($id_user) {
	   return $this->recipient[$id_user];
	}
}
?>
