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
	private $state;
	// Form anonymous
	private $anonymous;
	// Form printable
	private $printable;
	// Form multifill
	private $multifill;
	
	/*
		Constructor
	 */
	public function __construct() {
		switch(func_num_args()){
            case 0: // new Form();
            	$this->state = FALSE;
                break;
            case 1: // new Form(id);
               $this->id = func_get_arg(0);

			   $q = mysql_query("SELECT * FROM form WHERE form_id = " . $this->id);
			   $line = mysql_fetch_array($q);

			   $this->creator = new User($line["user_id"]);
			   $this->state = $line["form_status"] == 1 ? TRUE : FALSE;
			   $this->printable = $line["form_printable"] == 1 ? TRUE : FALSE;
			   $this->anonymous = $line["form_anonymous"] == 1 ? TRUE : FALSE;
            $this->multifill = $line["form_multifill"]; //Nom de colonne à syncronizer avec la bdd
			   $q = mysql_query("SELECT user_id, formdest_status FROM formdest WHERE form_id = " . $this->id . " ORDER BY user_id");
			   $this->recipient = [];
			   while($line = mysql_fetch_array($q)){
				   $this->recipient[] = new User($line["user_id"]);
			   }

			   $q = mysql_query("SELECT formans_id FROM formdest JOIN formans ON formdest.formdest_id = formans.formdest_id AND formdest.form_id = " . $this->id);
			   $this->ans = [];
			   while($line = mysql_fetch_array($q)){
				   $this->ans[] = new Answer($line["formans_id"]);
			   }
               break;
        }
	}

	/*
		Quirk
		To be deleted when new class Form is up & ready
	 */
	public function getListRecipient($ids, $state){
		$res = [];
		$res[] = ["FormDestId" => 63, "User" => new User(1), "Status" => FALSE, "Answer" => new Answer(63)];
		$res[] = ["FormDestId" => 64, "User" => new User(1), "Status" => FALSE, "Answer" => new Answer(63)];
		$res[] = ["FormDestId" => 65, "User" => new User(1), "Status" => FALSE, "Answer" => new Answer(63)];
		return $res;
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
		getAnswer
		Returns form's answers list
	 */
	public function getAnswer($user_ids = [], $state = -1){
		$res = [];
		foreach($this->ans as $a){

			$ok = TRUE;
			if(count($user_ids) AND !in_array($a->getUser()->getId(), $user_ids))
				$ok = FALSE;
			if($state != -1 AND $a->getState() != $state)
				$ok = FALSE;

			if($ok)
				$res[] = $a;
		}
		return $res;
	}
	
	/*
		getPrintable
		Returns if form is printable
	 */
	public function getPrintable(){
		return $this->printable;
	}
	
	/*
		getAnonymous
		Sets if form is anonymous
	 */
	public function getAnonymous(){
		return $this->anonymous;
	}

	/*
		setCreator
		Sets form's creator
	 */
	public function setCreator($user){
		$this->creator = $user;
	}
	
	/*
		setPrintable
		Sets if form is printable
	 */
	public function setPrintable($isPrintable){
		$this->printable = $isPrintable;
	}
	
	/*
		setAnonymous
		Sets if form is anonymous
	 */
	public function setAnonymous($isAnonymous){
		$this->anonymous = $isAnonymous;
	}
	
	/*
		setMultifill
		Set the number or fill allowed
	 */
	public function setMultifill($multifill){
		$this->multifill = $multifill;
	}

	/*
		setRecipient
		Sets form's dest list
	 */
	public function setRecipient($recipientList){
		$this->recipient = $recipientList;
	}

	/*
		save
		TODO verif attr!=NULL
	 */
	public function save(){
		// Forms can be created or loaded
		if($this->id == NULL) {			// Creates new form
			// Inserts status, anon & print
			mysql_query("INSERT INTO form(user_id, form_status, form_anonymous, form_printable) VALUES ("
									. $this->creator->getId()
									. ", 0, "
									. ($this->anonymous ? 1 : 0) . ", "
									. ($this->printable ? 1 : 0) . ")"
			) or die('<br><strong>SQL Error (1)</strong>:<br>'.mysql_error());

			// Gets generated ID back
			$this->id = mysql_insert_id();

		} else {				// Updates old form
			// Updates status, anon & print
			mysql_query("UPDATE form SET form_status = "   . ($this->state ? 1 : 0)
									.", form_anonymous = " . ($this->anonymous ? 1 : 0)
									.", form_printable = " . ($this->printable ? 1 : 0)
									." WHERE form_id = "   . $this->id
			) or die('<br><strong>SQL Error (2)</strong>:<br>'.mysql_error());

			// Cleans answers & recipients lines
			mysql_query("DELETE a FROM formans a JOIN formdest d ON a.formdest_id = d.formdest_id WHERE d.form_id = ".$this->id
			) or die('<br><strong>SQL Error (3)</strong>:<br>'.mysql_error());

			mysql_query("DELETE FROM formdest WHERE form_id = ".$this->id
			) or die('<br><strong>SQL Error (4)</strong>:<br>'.mysql_error());
		}

		// Inserts recipients & answers lines
		// We also have to set $this->ans to its new value
		$this->ans = [];
		foreach ($this->recipient as $d){
			mysql_query("INSERT INTO formdest(form_id, user_id, formdest_status) VALUES ("
									. $this->id.","
									. $d->getId()
									. ", 0)"
			) or die('<br><strong>SQL Error (5)</strong>:<br>'.mysql_error());

			$dest_id = mysql_insert_id();
			
			mysql_query("INSERT INTO formans(formdest_id) VALUES (" . $dest_id . ")"
			) or die('<br><strong>SQL Error (6)</strong>:<br>'.mysql_error());
			
			$ans_id = mysql_insert_id();
			
			$this->ans = new Answer($ans_id);
		}
	}

	/*
		send
	 */
	public function send(){
		$this->save();
		$this->state = TRUE;
		// Update status
		mysql_query("UPDATE form SET form_status = 1 WHERE form_id = ".$this->id
		) or die('<br><strong>SQL Error (7)</strong>:<br>'.mysql_error());
	}
}
?>
