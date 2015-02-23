<?php
	
	Class Form {
		private $id;
		private $creator;
		private $name;
		private $state;
		private $groups;
		private $print;
		private $anon;

<<<<<<< HEAD
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
	private $formGroups = array();
	
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
=======
		public function __construct($id = NULL){
			if($id !== NULL){
				// Id
				$this->id = $id;

				// Name, Status, Print, Anon
				$query = mysql_query ("	SELECT 	*
										FROM 	form
										WHERE 	form_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Form::__construct() : id not found !");
				}else{
					$results = mysql_fetch_array($query);

					$this->creator 		= new User($results["user_id"]);
					$this->name 		= $results["form_name"];
					$this->state 		= $results["form_status"] 		== 1 ? TRUE : FALSE;
					$this->print 	 	= $results["form_printable"] 	== 1 ? TRUE : FALSE;
					$this->anon 	 	= $results["form_anonymous"] 	== 1 ? TRUE : FALSE;
				}
				
				// Groups
				$query = mysql_query("	SELECT 		*
										FROM 		formgroup
										WHERE 		form_id = " . $this->id. "
										ORDER BY 	formgroup_id");

				if (!mysql_num_rows($query)){
					die("Form::__construct() : groups not found !");
				}else{
					$this->groups = [];
>>>>>>> L4Classes

					while ($results = mysql_fetch_array($query)){
						$this->groups[] = new Group($results["formgroup_id"]);
					}
				}
			}
		}

		public function creator($creator = NULL){
			// Get
			if($creator === NULL){
				return $this->creator;
			}
			// Set
			else{
				$this->creator = $creator;
				return $this;
			}
		}
<<<<<<< HEAD
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
	
	public function getFormGroups() {
		return $this->formGroups;
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
=======
>>>>>>> L4Classes

		public function name($name = NULL){
			// Get
			if($name === NULL){
				return $this->name;
			}
			// Set
			else{
				$this->name = $name;
				return $this;
			}
		}

		public function state($state = NULL){
			// Get
			if($state === NULL){
				return $this->state;
			}
			// Set
			else{
				$this->state = $state;
				return $this;
			}
		}
<<<<<<< HEAD
		
		//For each group: insert group, insert elements, insert recipients.
		foreach($this->formGroups as $indexGroup => $formGroup) {
			$formGroup->save($this->id);
=======

		public function groups($groups = NULL){
			// Get
			if($groups === NULL){
				return $this->groups;
			}
			// Set
			else{
				$this->groups = $groups;
				return $this;
			}
>>>>>>> L4Classes
		}

		public function printable($print = NULL){
			// Get
			if($print === NULL){
				return $this->print;
			}
			// Set
			else{
				$this->print = $print;
				return $this;
			}
		}

		public function anon($anon = NULL){
			// Get
			if($anon === NULL){
				return $this->anon;
			}
			// Set
			else{
				$this->anon = $anon;
				return $this;
			}
		}

		public function save() {
			// Create form
			if($this->id === NULL){
				mysql_query("INSERT INTO form(
											user_id,
											form_name,
											form_status,
											form_printable,
											form_anonymous)
									VALUES ("
										. $this->creator->id() . ","		// user_id
										. "'" . $this->name . "',"			// form_name
										. "0,"								// form_status
										. ($this->print ? 1 : 0) . ", "		// form_printable
										. ($this->anon 	? 1 : 0) . ")")			// form_anonymous
				or die("Form::save() can't create form : " . mysql_error());

				// Auto generated id
				$this->id = mysql_insert_id();
			}
			// Update form
			else{
				// Reset form
				mysql_query("	UPDATE 	form
								SET 	form_status 		= 		0,
				                  		form_name 			= '" . 	 $this->name . "',
										form_anonymous 		= "  . 	($this->anon 	? 1 : 0) . "
										form_printable 		= "  . 	($this->print 	? 1 : 0) . "
								WHERE 	form_id 			= "  . 	 $this->id)
				or die("Form::save() can't update form : " . mysql_error());
				
				// Delete groups
				foreach($this->$groups as $group){
					$group->delete();
				}
			}

			// Create groups
			foreach($this->groups as $group){
				$group->save($this->id);
			}
		}

		public function send(){
			$this->save();
			$this->state = TRUE;

			// Update status
			mysql_query("	UPDATE 	form
							SET 	form_status = 1
							WHERE 	form_id 	= " . $this->id)
			or die("Form::send() can't update status : " . mysql_error());
		}

		public function delete(){
			// Delete form (DELETE CASCADE)
			mysql_query("	DELETE FROM form
							WHERE 		form_id = " . $this->id)
			or die("Form::delete() can't delete form : " . mysql_error());
		}
	}

?>
