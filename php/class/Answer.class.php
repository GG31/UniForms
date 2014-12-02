<?php
class Answer {
	// Form dest id (it identifies an answer)
	private $formDest;
	// Form id
	private $formId;
	// User whose the form is destinated to
	private $recipient;
	// Answer's state
	private $state;
	
	// Answers array
	private $answers = array ();
	
	/*  Constructor	 */
	public function __construct($formdest_id = -1){
		if($formdest_id == -1){
			$this->state = FALSE;
		}else{
			$qFormDest = mysql_query("SELECT * FROM formdest WHERE formdest_id = ".$formdest_id);

<<<<<<< HEAD
			if (!mysql_num_rows($qFormDest)){
				//error
				exit();
			}

			$rFormDest = mysql_fetch_array($qFormDest);
			$this->formDest = $rFormDest["formdest_id"];
			$this->formId = $rFormDest["form_id"];
			$this->state = $rFormDest["formdest_status"] == 1 ? TRUE : FALSE;
			$this->recipient = new User($rFormDest["user_id"]);
			$sql = "SELECT formelement_id, value 
				FROM answervalue 
				JOIN elementanswer ON elementanswer.elementanswer_id = answervalue.elementanswer_id 
				WHERE elementanswer.formdest_id = ".$formdest_id;
			$q = mysql_query($sql);
			
			if (mysql_num_rows($q)){
				while($ans = mysql_fetch_array($q)){
					$answer = array("elementId" => $ans["formelement_id"], "value" => $ans["value"]);
					array_push($this->answers, $answer);
				}
=======
		if (!mysql_num_rows($qFormDest)){
			//error
			exit();
		}
		$rFormDest = mysql_fetch_array($qFormDest);
		$this->formDest = $rFormDest["formdest_id"];
		$this->formId = $rFormDest["form_id"];
		$this->recipient = new User($rFormDest["user_id"]);
		$sql = "SELECT formelement_id, value 
			FROM answervalue 
			JOIN elementanswer ON elementanswer.elementanswer_id = answervalue.elementanswer_id 
			WHERE elementanswer.formdest_id = " . $formdest_id;
		$q = mysql_query ( $sql );
		
		if (mysql_num_rows ( $q )) {
			while ( $ans = mysql_fetch_array ( $q ) ) {
				$answer = array (
						"elementId" => $ans ["formelement_id"],
						"value" => $ans ["value"] 
				);
				array_push ( $this->answers, $answer );
>>>>>>> 1bf716b5da4617c2ca09f19af039499114d7a1fc
			}
		}
	}
	
	/*
	 * getFormId
	 * Returns form's id
	 */
	public function getFormId() {
		return $this->formId;
	}
<<<<<<< HEAD

	/*  getFormId
		Returns formdest id */
	public function getId(){
		return $this->formDest;
=======
	
	/*
	 * getFormId
	 * Returns formdest id
	 */
	public function getId() {
		return $this->formDestId;
>>>>>>> 1bf716b5da4617c2ca09f19af039499114d7a1fc
	}

	/*  getRecipient
		Returns $this->recipient
	*/
	public function getRecipient(){
		return $this->recipient;
	}

	/*  getState
		Returns $this->state
	*/
	public function getState(){
		return $this->state;
	}

	/*  setFormId
		Sets form's id
	*/
	public function setFormId($formId){
		$this->formId = $formId;
	}

	/*  setRecipient
		Sets recipient User object
	*/
	public function setRecipient($recipient){
		$this->recipient = $recipient;
	}

	/*
		save
	*/
	public function save(){
		// Ans can be created or loaded
		if($this->formDest == NULL) {			// Creates new ans
			// Inserts status, anonymous, print and maxAnswers
			mysql_query("INSERT INTO formdest(formdest_status, user_id, form_id) VALUES ("
				. "0, "
				. $this->recipient->getId() . ", "
				. $this->formId
				. ") "
			) or die('<br><strong>SQL Error (1)</strong>:<br>'.mysql_error());
			$this->formDest = mysql_insert_id();

		} else {				// Updates existing ans
			// Only delete old element answer
			// (status is still 0, same form & dest)
			mysql_query("DELETE FROM elementanswer WHERE form_dest = ".$this->formDest);
		}

		//Fill array answers and after...
<<<<<<< HEAD
		foreach($this->answers as $answer){
			mysql_query("INSERT INTO elementanswer (formelementid, formdestid) VALUES(".$answer["elementId"].",".$this->formDest.")");
			$idElementAnswer = mysql_insert_id();	
			mysql_query("INSERT INTO answervalue (value, elementanswer_id) VALUES(".$answer["value"].",".$idElementAnswer.")");			
		}
	}

	/*  send  */
	public function send(){
=======
		
		mysql_query("DELETE FROM elementanswer WHERE form_dest = ".$this->formDest);

		foreach ( $this->answers as $answer ) {
			mysql_query ( "INSERT INTO elementanswer (formelementid, formdestid) VALUES(" . $answer ["elementId"] . "," . $this->formDest . ")" );
			$idElementAnswer = mysql_insert_id ();
			mysql_query ( "INSERT INTO answervalue (value, elementanswer_id) VALUES(" . $answer ["value"] . "," . $idElementAnswer . ")" );
		}
	}
	
	/* send */
	public function send() {
		$this->save ();
>>>>>>> 1bf716b5da4617c2ca09f19af039499114d7a1fc
		$this->state = TRUE;
		// Update status
		mysql_query ( "UPDATE formdest SET formdest_status = 1 WHERE formdest_id = " . $this->formDest );
	}
}
?>