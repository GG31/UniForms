<?php
class Form {
	// Form id (form_id)
	private $id = NULL;
	
	// Form creator (User object which represents the creator)
	private $creator;
	
	// Form status (TRUE (validated) or FALSE(not validated yet))
	private $state;
	
	// Form anonymous (TRUE or FALSE)
	private $anonymous;
	
	// Form printable (TRUE or FALSE)
	private $printable;
	
	//Form  (Integer - Sets the number of times that the form can be answered)
	private $maxAnswers;
	
	// Form dest-answers list (One list that contains three elements: one object user that is the recipient, one status and one object answer)
	private $listRecipient;
	
	//Form elements list (The list of all elements of one form)
	private $formElements = array();
	
	/* Constructor */
	public function __construct($idForm = -1) {
        if ($idForm == -1)
            	$this->state = FALSE;
		else{   
			$qForm = mysql_query("SELECT * FROM form WHERE form_id = " . $idForm);
			if(!mysql_num_rows($qForm)){
				//Error...
				exit;
			}
				
			$this->id = $idForm;
			$rForm = mysql_fetch_array($qForm);

			$this->creator = new User($rForm["user_id"]);
			$this->state = $rForm["form_status"] == 1 ? TRUE : FALSE;
			$this->printable = $rForm["form_printable"] == 1 ? TRUE : FALSE;
			$this->anonymous = $rForm["form_anonymous"] == 1 ? TRUE : FALSE;
			$this->maxAnswers = $rForm["form_maxanswers"];
	
			$this->listRecipient = array();
			$qFormDest = mysql_query("SELECT formdest_id, user_id, formdest_status FROM formdest WHERE form_id = " . $this->id . " ORDER BY user_id, formdest_id");
			while($rFormDest = mysql_fetch_array($qFormDest)){
				$recipient = array("User" => new User($rFormDest["user_id"]), "Status" => $rFormDest["formdest_status"], "Answer" => new Answer($rFormDest["formdest_id"]), "formDestId" => $rFormDest["formdest_id"]);
				array_push($this->listRecipient, $recipient);
			}
			
		}
	}

	/*  id
		Returns form's id */
	public function getId(){
		return $this->id;
	}

	/*  state
		Returns form's status */
	public function getState(){
		return $this->state;
	}

	/*  getCreator
		Returns form's creator */
	public function getCreator(){
		return $this->creator;
	}
	
	/*  getMaxAnswers
		Returns number of maximum answers by user */
	public function getMaxAnswers(){
		return $this->maxAnswers;
	}
	
	/*  getRecipient
		Returns form's dest list */
	public function getRecipient(){
		$recipients = array();
		foreach($this->listRecipient as $user)
			if(!in_array($user["User"], $recipients))
				array_push($recipients, $user["User"]);
		return $recipients;
	}
	
	/*  getPrintable
		Returns if form is printable */
	public function getPrintable(){
		return $this->printable;
	}
	
	/*  getAnonymous
		Sets if form is anonymous  */
	public function getAnonymous(){
		return $this->anonymous;
	}
	
	/*  getAnonymous
		Sets if form is anonymous  */
	public function getListRecipient(){
		return $this->listRecipient;
	}
	
	/*  getAnonymous
		Sets if form is anonymous  */
	public function getFormElements(){
		return $this->formElements;
	}

	/*  setCreator
		Sets form's creator  */
	public function setCreator($user){
		$this->creator = $user;
	}
	
	/*  setPrintable
		Sets if form is printable  */
	public function setPrintable($isPrintable){
		$this->printable = $isPrintable;
	}
	
	/*  setAnonymous
		Sets if form is anonymous */
	public function setAnonymous($isAnonymous){
		$this->anonymous = $isAnonymous;
	}

	/*  setMaxAnswers
		Sets MaxAnswers */
	public function setMaxAnswers($maxAnswers){
		$this->maxAnswers = $maxAnswers;
	}
	
	/*  Use only on form create!
		setRecipient
		Sets form's dest list  */
	public function setRecipient($recipientList){
		$this->listRecipient = array();
		foreach ($recipientList as $recipient){
			$recipient = array("User" => $recipient, "Status" => "False", "Answer" => NULL, "formDestId" => NULL);
			array_push($this->listRecipient, $recipient);
		}
	}

	/*  save  */
	public function save(){
		// Forms can be created or loaded
		if($this->id == NULL) {			// Creates new form
			// Inserts status, anonymous, print and maxAnswers
			mysql_query("INSERT INTO form(user_id, form_status, form_anonymous, form_printable, form_maxanswers) VALUES ("
									. $this->creator->getId()
									. ", 0, "
									. ($this->anonymous ? 1 : 0) . ", "
									. ($this->printable ? 1 : 0) . ", "
									. $this->maxAnswers 
									. ") "
			) or die('<br><strong>SQL Error (1)</strong>:<br>'.mysql_error());
			$this->id = mysql_insert_id();

		} else {				// Updates existing form
			// Updates status, anonymous, print and maxAnswers
			mysql_query("UPDATE form SET form_status = "   . ($this->state ? 1 : 0)
									.", form_anonymous = " . ($this->anonymous ? 1 : 0)
									.", form_printable = " . ($this->printable ? 1 : 0)
									.", form_maxanswers = " . $this->maxAnswers
									." WHERE form_id = "   . $this->id
			) or die('<br><strong>SQL Error (2)</strong>:<br>'.mysql_error());
			
			mysql_query("DELETE FROM formdest WHERE form_id = ".$this->id
			) or die('<br><strong>SQL Error (4)</strong>:<br>'.mysql_error());
			
			// Delete form elements here...
		}
		
		// Inserts recipients in formdest
		foreach ($this->listRecipient as $key => $recipient){
			for ($i = 0; $i < 1; $i++){  // Includes this->maxAnsers times for each recipient
				mysql_query("INSERT INTO formdest(form_id, user_id, formdest_status) VALUES ("
										. $this->id.","
										. $recipient["User"]->getId()
										. ", 0)"
				) or die('<br><strong>SQL Error (5)</strong>:<br>'.mysql_error());
				// Preencher $this->listRecipient com o novo formdest
				$this->listRecipient[$key]["formDestId"] = mysql_insert_id();
			}
		}
	
		//Insert FormElements here...
	}

	/* save() and update status */
	public function send(){
		$this->save();
		$this->state = TRUE;
		// Update status
		mysql_query("UPDATE form SET form_status = 1 WHERE form_id = ".$this->id
		) or die('<br><strong>SQL Error (7)</strong>:<br>'.mysql_error());
	}
}
?>