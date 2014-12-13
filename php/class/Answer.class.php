<?php
/**
 * Represents an answer 
 */
class Answer {
	/**
	  * id of the answer
     * @access private
     * @var integer 
     */
	private $formDest;
	
	/**
     * @access private
     * @var integer 
     */
	private $formId;
	
	/**
	  * User who fill the answer
     * @access private
     * @var User
     */
	private $recipient;
	
	/**
	  * Answer's state, TRUE if sent, FALSE if not
     * @access private
     * @var boolean 
     */
	private $state;
	
	/**
     * @access private
     * @var array of answer. An answer is an array of two elements, "elementId" and "value". "elementId" represents one element of the form and "value" the value of the answer to this element 
     */
	private $answers = array ();
	
	/**
	 * Constructor
	 * Create an answer, if already exist fill the attributes from the database
	 * @param integer $formdest_id the id's answer default -1
	 */
	public function __construct($formdest_id = -1){
		if($formdest_id == -1){
			$this->state = FALSE;
		}else{
			$qFormDest = mysql_query("SELECT * FROM formdest WHERE formdest_id = ".$formdest_id);

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
			}
		}
	}
	
	/**
	 * Give the form's id
	 * @return integer
	 */
	public function getFormId() {
		return $this->formId;
	}
	
	/**
	 * Give the formDest's id
	 * @return integer
	 */
	public function getId() {
		return $this->formDest;
	}

	/**
	 * Give the user corresponding to the answer
	 * @return User
	 */
	public function getRecipient(){
		return $this->recipient;
	}

	/**
	 * Give the answer's state
	 * @return boolean TRUE (validated) or FALSE(not validated yet)
	 */
	public function getState(){
		return $this->state;
	}

	/**
    * Sets the formId value
    * @param integer $formId the id of the associated form
    */
	public function setFormId($formId){
		$this->formId = $formId;
	}

	/**
    * Sets the User who have to answer
    * @param User $recipient the user who will answer the form formId
    */
	public function setRecipient($recipient){
		$this->recipient = $recipient;
	}
	
	/**
	 * Created for the test (at the moment, there's no way to fill this array...)
    * Sets the elements of answers
    * @param ?? $answers
    */
	public function setAnswers($answers){
		 $this->answers = $answers;
	}

	/**
	 * Give the answers
	 * @return array of ??
	 */
	public function getAnswers(){
		return $this->answers;
	}
	
	/**
	 * Save the form on the database
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
		
		// Update tables elementanswer and answervalue
		$answers = $this->getAnswers();
		foreach($answers as $answer){
			mysql_query("INSERT INTO elementanswer (formelement_id, formdest_id) VALUES(".$answer["elementId"].",".$this->getId().")");
			$idElementAnswer = mysql_insert_id();	
			mysql_query("INSERT INTO answervalue (value, elementanswer_id) VALUES(".$answer["value"].",".$idElementAnswer.")");			
		}
	}
	
	/**
	 * save() and update status to TRUE
	 */
	public function send() {
		$this->save ();
		$this->state = TRUE;
		// Update status
		mysql_query ( "UPDATE formdest SET formdest_status = 1 WHERE formdest_id = " . $this->formDest );
	}
	
	/** 
	* Delete all registers related to an answer and in the tables formdest, elementanswer, answervalue
	*/
	public function deleteAnswer(){
		// Delete the form. All related to this form is deleted on cascade according to the definition of the foreign keys
		mysql_query("DELETE FROM formdest WHERE formdest_id = ".$this->getId());
	}
	
}
?>
