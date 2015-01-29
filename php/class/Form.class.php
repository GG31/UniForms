<?php
/**
 * Represents a form that has an id, a creator, a state, two booleans properties to define if it is anonymous and printable and an array of groups of elements and recipients.
 */
class Form {
	/**
     * @access private
     * @var integer 
     */
	private $id = NULL;
	
	/**
     * @access private
     * @var string 
     */
	private $name = NULL;
	
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
	
	/*
	* A form group is a group of form elements and the recipients that can answer these elements.
	* @access private
	* @var FormGroup 
	*/
	private $formGroups;
	
	/**
	 * Constructor
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
			$this->name = $rForm ["form_name"];
			
			// Load Groups
			$this->formGroups = array();
			$qFormGroup = mysql_query("SELECT * FROM formgroup WHERE form_id = ".$this->id);
			while ($rFormGroup = mysql_fetch_array($qFormGroup)){
				array_push ($this->formGroups, new FormGroup($rFormGroup["formgroup_id"]));
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
	 * Give the form's name
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
	/*public function getRecipient() {
		$recipients = array ();
		foreach ( $this->listRecipient as $user )
			if (! in_array ( $user ["User"], $recipients ))
				array_push ( $recipients, $user ["User"] );
		return $recipients;
	}*/
	
	/**
	 * Give printable variable
	 * @return boolean true if printable, false if is not
	 */
	public function getPrintable() {
		return $this->printable;
	}
	
	/**
	 * Give anonymous variable
	 * @return boolean true if is anonymous, false if is not
	 */
	public function getAnonymous() {
		return $this->anonymous;
	}
	
	/**
	 * Give all elements of the form
	 * @return array of elements
	 */
	public function getFormElements() {
		$res = [];
		foreach ($this->formGroups as $group)
			$res = array_merge($res, $group->getGroupElements()); // Union of arrays		
		return $res;
	}
	
	/**
	 * Give the list of recipient who have the status of its answers equals to $state
	 * @param array of integer $user_ids
	 * @param integer $state. (default: -1) state of answers
	 * @return array of User
	 */
	public function getFormRecipients($user_ids = [], $state = -1){
		$res = [];
		foreach ($this->formGroups as $group)
			$res = array_merge($res, $group->getFormGroupRecipients($user_ids, $state)); // Union of arrays		
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
    * Sets the name of the form
    * @param string $name
    */
	public function setName($name){
		$this->name = $name;
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
	 * Save the form on the database
	 */
	public function save() {
		// Forms can be created or loaded
		if($this->id == NULL) {			// Creates new form
			// Inserts status, anonymous, print and maxAnswers
			mysql_query("INSERT INTO form(user_id, form_name, form_status, form_anonymous, form_printable, form_maxanswers) VALUES ("
									. $this->creator->getId()
									. ",'" . $this->name . "'"
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
			                  .", form_name = '" . $this->name ."'" 
									.", form_anonymous = " . ($this->anonymous ? 1 : 0)
									.", form_printable = " . ($this->printable ? 1 : 0)
									.", form_maxanswers = " . $this->maxAnswers
									." WHERE form_id = "   . $this->id
			) or die('<br><strong>SQL Error (2)</strong>:<br>'.mysql_error());
			
			// Cleans form groups list in db. It automatically cleans formelements and formdest.
			mysql_query("DELETE FROM formgroup WHERE form_id = ".$this->id
			) or die('<br><strong>SQL Error (5)</strong>:<br>'.mysql_error());
		}
		
		//For each group: insert group, insert elements, insert recipients.
		foreach($this->formGroups as $indexGroup => $formGroup){
			$formGroup->save($this->id);
		}
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
	
	/**
    * Add a group to the form
    * @param array FormGroup $listGroup
    */
	public function setGroups($listGroup){
		$this->formGroups = $listGroup;
	}
}
?>
