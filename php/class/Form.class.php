<?php
/**
 * Represents a form which have an id, creator, state, can be anonymous, printable and have a list of recipient and elements.
 */
class Form {
	/**
     * @access private
     * @var integer 
     */
	private $id = NULL;
	
	/**
	  * Creator of this form
     * @access private
     * @var User 
     */
	private $creator;

	/**
	  * State of the form 
     * @access private
     * @var boolean TRUE (validated) or FALSE(not validated yet)
     */
	private $state;
	
	/**
	  * Form which can be filled by everybody 
     * @access private
     * @var boolean TRUE (anonymous) or FALSE(not anonymous)
     */
	private $anonymous;
	
	/**
	  * Form which can be printed
     * @access private
     * @var boolean TRUE (printable) or FALSE(not printable)
     */
	private $printable;
	
	/**
	  * The number of answer accepted by a recipient.
     * @access private
     * @var integer number of allowed answers
     */
	private $maxAnswers;
	
	/**
	  * List of recipient for this form, for each recipient there are the status, the Answer and the formDestId associated.
     * @access private
     * @var array of elements 
     */
	private $listRecipient;
	
	/**
	 * List of elements of this form. Each element of this list is basically a representation of one line of the table formelement.
	 * @access private
	 * @var array of elements
	 */
	private $formElements;
	
	/** Constructor
	 * Create a form, if already exist, find the information on the database to fill the attributes
	 * @param integer $idForm the id's form default -1
	 */
	public function __construct($idForm = -1) {
		if ($idForm == - 1)
			$this->state = FALSE;
		else {
			$this->id = $idForm;

			$qForm = mysql_query ( "SELECT * FROM form WHERE form_id = " . $idForm );
			if (! mysql_num_rows ( $qForm )) {
				// Error...
				exit ();
			}
			
			$rForm = mysql_fetch_array ( $qForm );
			
			$this->creator = new User ( $rForm ["user_id"] );
			$this->state = $rForm ["form_status"] == 1 ? TRUE : FALSE;
			$this->printable = $rForm ["form_printable"] == 1 ? TRUE : FALSE;
			$this->anonymous = $rForm ["form_anonymous"] == 1 ? TRUE : FALSE;
			$this->maxAnswers = $rForm ["form_maxanswers"];
			
			// Load listRecipient
			$this->listRecipient = array ();
			$qFormDest = mysql_query ( "SELECT formdest_id, user_id, formdest_status FROM formdest WHERE form_id = " . $this->id . " ORDER BY user_id, formdest_id" );
			while ( $rFormDest = mysql_fetch_array ( $qFormDest ) ) {
				$recipient = array (
						"User" => new User ( $rFormDest ["user_id"] ),
						"Status" => $rFormDest ["formdest_status"] == 1 ? TRUE : FALSE,
						"Answer" => new Answer ( $rFormDest ["formdest_id"] ),
						"formDestId" => $rFormDest ["formdest_id"] 
				);
				array_push ( $this->listRecipient, $recipient );
			}
			
			// Load formElements
			$this->formElements = array ();
			$qFormElements = mysql_query("SELECT * FROM formelement WHERE form_id = " . $this->id);
			while ( $rFormElements = mysql_fetch_array ( $qFormElements ) ) {
				$element = new Element ( $rFormElements ["formelement_id"] );
				array_push ( $this->formElements, $element );
			}
		}
	}
	
	/**
	 * Give the form's id
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Give the form's state
	 * @return boolean TRUE (validated) or FALSE(not validated yet)
	 */
	public function getState() {
		return $this->state;
	}
	
	/**
	 * Give the form's creator
	 * @return User
	 */
	public function getCreator() {
		return $this->creator;
	}
	
	/**
	 * Give the form's maxAnswers, the maximum of fill possibilities by one recipient
	 * @return integer
	 */
	public function getMaxAnswers() {
		return $this->maxAnswers;
	}
	
	/**
	 * Give all recipients of the form
	 * @return array of User
	 */
	public function getRecipient() {
		$recipients = array ();
		foreach ( $this->listRecipient as $user )
			if (! in_array ( $user ["User"], $recipients ))
				array_push ( $recipients, $user ["User"] );
		return $recipients;
	}
	
	/*
	 * Give printable variable
	 * @return boolean true if printable, false if is not
	 */
	public function getPrintable() {
		return $this->printable;
	}
	
	/*
	 * Give anonymous variable
	 * @return boolean true if is anonymous, false if is not
	 */
	public function getAnonymous() {
		return $this->anonymous;
	}
	
	/*
	 * Give all elements of the form
	 * @return array of elements
	 */
	public function getFormElements() {
		return $this->formElements;
	}
	
	/**
	 * Give the list of recipient who have the status of its answers equals to $state
	 * @param array of User $user_ids
	 * @param integer $state. (default: -1) state of answers
	 * return array of User
	 */
	public function getListRecipient($user_ids = [], $state = -1){
		$res = [];

		foreach($this->listRecipient as $r){
			// $r : User Status Answer formDestId
			$ok = TRUE;
			if(count($user_ids) AND !in_array($r["User"]->getId(), $user_ids))
				$ok = FALSE;
			if($state != -1 AND $r["Status"] != $state)
				$ok = FALSE;
			if($ok)
				$res[] = $r;
		}
		return $res;
	}

   /**
    * Sets the creator of the form
    * @param User $user
    */
	public function setCreator($user){
		$this->creator = $user;
	}
	
	/**
    * Sets the printable value
    * @param boolean $isPrintable
    */
	public function setPrintable($isPrintable) {
		$this->printable = $isPrintable;
	}
	
	/**
    * Sets the anonymous value
    * @param boolean $isAnonymous
    */
	public function setAnonymous($isAnonymous) {
		$this->anonymous = $isAnonymous;
	}
	
	/**
	 * Set the maxAnswers value, number maximum of answers by a recipient
	 * @param integer $maxAnswers
	 */
	public function setMaxAnswers($maxAnswers) {
		$this->maxAnswers = $maxAnswers;
	}
	
	/**
	 * Set the elements of form
	 * @param array of Element
	 */
	public function setFormElements($elementsList) {
		$this->formElements = $elementsList;
	}
	
	/**
	 * Give recipient to the form, if the form is already sent, the method will do nothing.
	 * @param array of User $recipientList
	 */
	public function setRecipient($recipientList) {
	   if (!$this->state) {
		   $this->listRecipient = array ();
		   foreach ( $recipientList as $recipient ) {
			   $recipient = array (
					   "User" => $recipient,
					   "Status" => "False",
					   "Answer" => NULL,
					   "formDestId" => NULL 
			   );
			   array_push ( $this->listRecipient, $recipient );
		   }
		}
	}
	
	/**
	 * Save the form on the database
	 */
	public function save() {
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
			mysql_query("UPDATE form SET form_status = 0"
									.", form_anonymous = " . ($this->anonymous ? 1 : 0)
									.", form_printable = " . ($this->printable ? 1 : 0)
									.", form_maxanswers = " . $this->maxAnswers
									." WHERE form_id = "   . $this->id
			) or die('<br><strong>SQL Error (2)</strong>:<br>'.mysql_error());
			
			// Cleans dest list in DB
			mysql_query("DELETE FROM formdest WHERE form_id = ".$this->id
			) or die('<br><strong>SQL Error (3)</strong>:<br>'.mysql_error());
			
			// Clean form elements list in db
			mysql_query("DELETE FROM formelement WHERE form_id = ".$this->id
			) or die('<br><strong>SQL Error (4)</strong>:<br>'.mysql_error());
		}
		
		// Inserts recipients in formdest
		foreach ($this->listRecipient as $index => $recipient){
			mysql_query("INSERT INTO formdest(form_id, user_id, formdest_status) VALUES ("
									. $this->id.","
									. $recipient["User"]->getId()
									. ", 0)"
			) or die('<br><strong>SQL Error (5)</strong>:<br>'.mysql_error());
			
			$this->listRecipient[$index]["formDestId"] = mysql_insert_id();
		}
		
		// Insert elements of the form in formelement
		foreach ($this->formElements as $index => $element){
			mysql_query("INSERT INTO formelement(form_id, type_element, pos_x, pos_y, default_value, required, width, height, placeholder, direction, isbiglist, max_value, min_value) 
						VALUES ("
									. $this->id . ","
									. $element->getTypeElement() . ","
									. $element->getX() . ","
									. $element->getY() . ","
									. "'" . $element->getDefaultValue() . "',"
									. ($element->getRequired() ? 1 : 0) . ", "
									. $element->getWidth() . ","
									. $element->getHeight() . ","
									. "'" . $element->getPlaceholder() . "',"
									. $element->getDirection() . ","
									. ($element->getIsbiglist() ? 1 : 0) . ","
									. $element->getMaxvalue() . ","
									. $element->getMinvalue() .
						")"
			) or die('<br><strong>SQL Error (6)</strong>:<br>'.mysql_error());
			
			$formElementId = mysql_insert_id();
			//update new id
			$this->formElements[$index]->setId($formElementId);
			
			// Insert the options of an element
			if (is_array($element->getOptions())){
				$optionsList = $element->getOptions();
				foreach ($optionsList as $optIndex => $option){
					mysql_query("INSERT INTO elementoption(formelement_id, optionvalue, optionorder, optiondefault) VALUES ("
											. $formElementId . ","
											. "'" . $option["value"] . "',"
											. $option["order"] . ","
											. ($option["default"] ? 1 : 0) .
								")"
					) or die('<br><strong>SQL Error (7)</strong>:<br>'.mysql_error());
					
					// update new id
					$option["elementoption_id"] = mysql_insert_id();
					$optionsList[$optIndex] = $option;
				}
				$element->setOptions($optionsList);
			}
		}
		
	}

   /**
    * Create answer for a user defined by $idUser
    * @param integer $idUser
    */
	public function createAnswer($idUser) {
	   mysql_query("INSERT INTO formdest(form_id, user_id, formdest_status) VALUES ("
										. $this->id.","
										. $idUser
										. ", 0)"
				) or die('<br><strong>SQL Error (5)</strong>:<br>'.mysql_error());
	}

	/**
	 * save() and update status to TRUE
	 */
	public function send() {
		$this->save ();
		$this->state = TRUE;
		// Update status
		mysql_query ( "UPDATE form SET form_status = 1 WHERE form_id = " . $this->id ) or die ( '<br><strong>SQL Error (7)</strong>:<br>' . mysql_error () );
	}
	
	/**
	 * Delete one form and all registers related to it in other tables (formdest, formelement, elementanswer, answervalue) 
	 */
	public function deleteForm(){
		// Delete the form. All related to this form is deleted on cascade according to the definition of the foreign keys
		mysql_query("DELETE FROM form WHERE form_id = ".$this->getId());
	}
}
?>
