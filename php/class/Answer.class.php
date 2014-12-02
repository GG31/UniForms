<?php
class Answer {
	// Form dest id (it identifies an answer)
	private $formDest;
	// User whose the form is destinated to
	private $recipient;
	// Form id
	private $formId;
	
	// Answers array
	private $answers = array ();
	
	/*  Constructor	 */
	public function __construct($formdest_id){
		$qFormDest = mysql_query("SELECT * FROM formdest WHERE formdest_id = ".$formdest_id);

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
	
	/*
	 * getFormId
	 * Returns formdest id
	 */
	public function getId() {
		return $this->formDest;
	}

	/*  getRecipient
		Returns $this->recipient
	*/
	public function getRecipient(){
		return $this->recipient;
	}

	/*  save  */
	public function save(){
		//Fill array answers and after...
		
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
		$this->state = TRUE;
		// Update status
		mysql_query ( "UPDATE formdest SET formdest_status = 1 WHERE formdest_id = " . $this->formDest );
	}
}
?>