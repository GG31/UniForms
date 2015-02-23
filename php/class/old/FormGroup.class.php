<?php
/*
 * A group represents a subset of fields of one form. It contains three properties: an id, a list of recipients and a list of fields.
 */

class FormGroup{
 	/**
     * @access private
     * @var integer 
     */
	private $id = NULL;
	
	/**
	 * List of recipient for this group, for each recipient there are the status, the Answer and the formDestId associated.
     * @access private
     * @var array of elements 
     */
	private $listRecipient = array();
	
	/**
	 * List of elements of this form. Each element of this list is basically a representation of one line of the table formelement.
	 * @access private
	 * @var array of elements
	 */
	private $groupElements = array();
	
	/**
	 * The number of answer accepted by a recipient. 0 is infinite
     * @access private
     * @var integer number of allowed answers
     */
	private $maxAnswers;
	
	/**
	 * The number of the group. Groups are ordered !
     * @access private
     * @var integer group number
     */
	private $number;
	
	/**
	 * Constructor
	 * Create a form group, if already exist, find the information on the database to fill the attributes
	 * @param integer $idForm the id's form default -1
	 */
	public function __construct($idFormGroup = -1) {
		if ($idFormGroup != -1)	{
			
			$this->id = $idFormGroup;

			// TODO verify this !
			$qFormGroup = mysql_query ( "SELECT group_maxanswers, group_number
										FROM formgroup
										WHERE formgroup_id = " . $this->id );
			$rFormGroup = mysql_fetch_array ( $qFormGroup );
			$this->maxAnswers = $rFormGroup["group_maxanswers"];
			$this->number = $rFormGroup["group_number"];
			
			// Load listRecipient
			$this->listRecipient = array ();
			$qFormDest = mysql_query ( "SELECT formdest_id, user_id, formdest_status FROM formdest WHERE formgroup_id = " . $this->id . " ORDER BY user_id, formdest_id" );
			while ( $rFormDest = mysql_fetch_array ( $qFormDest ) ) {
				$recipient = array (
						"User" => new User ( $rFormDest ["user_id"] ),
						"Status" => $rFormDest ["formdest_status"] == 1 ? TRUE : FALSE,
						"Answer" => new Answer ( $rFormDest ["formdest_id"] ),
						"formDestId" => $rFormDest ["formdest_id"] 
				);
				array_push ( $this->listRecipient, $recipient );
			}
			
			// Load groupElements
			$this->groupElements = array ();
			$qFormElements = mysql_query("SELECT * FROM formelement WHERE formgroup_id = " . $this->id);
			while ( $rFormElements = mysql_fetch_array ( $qFormElements ) ) {
				$element = new Element ( $rFormElements ["formelement_id"] );
				array_push ( $this->groupElements, $element );
			}
		}
	}
	
	/**
	 * Returns the formgroup's id
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

   /**
    * Sets the formgroup's id
    * @param integer $id
    */
	public function setId($id){
		$this->id = $id;
	}
	
	/**
    * Create answer for a user defined by $idUser
    * @param integer $idUser
    */
	public function createAnswer($idUser) {
		mysql_query("INSERT INTO formdest(
	   								formgroup_id,
	   								user_id,
	   								formdest_status
	   							) VALUES ("
									. $this->id .","		// formgroup_id
									. $idUser . ", "		// user_id
									. "0)")					// formdest_status
		or die('<br><strong>SQL Error (FormGroup::createAnswer() 1)</strong>:<br>'.mysql_error());
	}
	
	/**
	 * Give the list of recipient who have the status of its answers equals to $state
	 * @param array of integer $user_ids
	 * @param integer $state. (default: -1) state of answers
	 * @return array of User
	 */
	public function getFormGroupRecipients($user_ids = [], $state=-1){
		$res = [];
		foreach($this->listRecipient as $r)
			if(($r["Status"] == $state or $state==-1) and ((!empty($user_ids) and in_array($r["User"]->getId(), $user_ids)) or empty($user_ids)))
				$res[] = $r;
		return $res;
	}
	
	public function getGroupElements(){
		return $this->groupElements;
	}
	
	/**
	 * Give the form's maxAnswers, the maximum of fill possibilities by one recipient
	 * @return integer
	 */
	public function getMaxAnswers() {
		return $this->maxAnswers;
	}

	/**
	 * Get the group number
	 * @return integer
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * Get the recipient list (i.e with answer, status, and formdest_id)
	 * Can be filtered with user ids and answer state
	 * @param $user_ids : array of integer (optional)
	 * @param $state 	: integer (optional)
	 * @return array of recipients (User/State/Answer/FormDestId)
	 */
	public function getRecipients($user_ids = [], $state = -1) {
		$res = [];
		foreach($this->listRecipient as $r)
			if(($r["Status"] == $state or $state==-1) and ((!empty($user_ids) and in_array($r["User"]->getId(), $user_ids)) or empty($user_ids)))
				$res[] = $r;
		return $res;
	}
	
	/**
	 * Set the maxAnswers value, number maximum of answers by a recipient
	 * @param integer $maxAnswers
	 */
	public function setMaxAnswers($maxAnswers) {
		$this->maxAnswers = $maxAnswers;
	}
	
	/**
	 * Set group number
	 * @param integer $maxAnswers
	 */
	public function setNumber($number) {
		$this->number = $number;
	}
	
	/**
	 * Sets elements to form group
	 * @param array of Element
	 */
	public function setFormGroupElements($elementsList) {
		$this->groupElements = $elementsList;
	}
	
	/**
	 * Sets recipients to the form group.
	 * @param array of User $recipientList
	 */
	public function setRecipients($recipientList) {
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
	
	/**
	 * Saves the group on the database
	 * @param integer $formId
	 */
	public function save($formId){
		// Insert group
		mysql_query("INSERT INTO formgroup(
									form_id,
									group_maxanswers,
									group_number)
							VALUES (" . 
									$formId 			. "," .	// form_id
									$this->maxAnswers 	. "," .	// group_maxanswers
									$this->number 		. ")") 	// group_number
		or die('<br><strong>SQL Error (FormGroup::save() 1)</strong>:<br>'.mysql_error());

		// Auto generated formgroup Id
		$this->setId(mysql_insert_id());
		
		// Inserts recipients in formdest
		foreach ($this->listRecipient as $index => $recipient){
			mysql_query("INSERT INTO formdest(
										formgroup_id,
										user_id,
										formdest_status
						) VALUES ("
									. $this->getId() . ","						// formgroup_id
									. $recipient["User"]->getId() . ", "		// user_id
									. "0)")										// formdest_status
			or die('<br><strong>SQL Error (FormGroup::save() 2)</strong>:<br>'.mysql_error());
			
			// Autogenerated formdest Id
			$this->listRecipient[$index]["formDestId"] = mysql_insert_id();
		}
		
		// Insert elements of the formgroup in formelement
		foreach ($this->groupElements as $index => $element){
			mysql_query("INSERT INTO formelement(
										formgroup_id,
										type_element,
										label,
										pos_x,
										pos_y,
										default_value,
										required,
										width,
										height,
										placeholder,
										direction,
										isbiglist,
										max_value,
										min_value
							) VALUES ("
									. 		$this->getId() 						. ","	// formgroup_id
									. 		$element->getTypeElement() 			. ","	// type_element
									. "'" . $element->getLabel() 				. "',"	// label
									. 		$element->getX() 					. ","	// pos_x
									. 		$element->getY() 					. ","	// pos_y
									. "'" . $element->getDefaultValue() 		. "',"	// default_value
									. 		($element->getRequired() ? 1 : 0) 	. ", "	// required
									. 		$element->getWidth() 				. ","	// width
									. 		$element->getHeight() 				. ","	// height
									. "'" . $element->getPlaceholder() 			. "',"	// placeholder
									. 		$element->getDirection() 			. ","	// direction
									. 		($element->getIsbiglist() ? 1 : 0) 	. ","	// isbiglist
									. 		$element->getMaxvalue() 			. ","	// max_value
									. 		$element->getMinvalue() 			. ")")	// min_value
			or die('<br><strong>SQL Error (FormGroup::save() 3)</strong>:<br>'.mysql_error());
			
			$formElementId = mysql_insert_id();
			//update new id
			$this->groupElements[$index]->setId($formElementId);
			
			// Insert the options of an element
			if (is_array($element->getOptions())){
				$optionsList = $element->getOptions();
				foreach ($optionsList as $optIndex => $option){
					mysql_query("INSERT INTO elementoption(
												formelement_id,
												optionvalue,
												optionorder,
												optiondefault
									) VALUES ("
											. 		$formElementId 					. ","	// formelement_id
											. "'" . $option["value"] 				. "',"	// optionvalue
											. 		$option["order"] 				. ","	// optionorder
											. 		($option["default"] ? 1 : 0) 	. ")")	// optiondefault
					or die('<br><strong>SQL Error (9)</strong>:<br>'.mysql_error());
					
					// update new id
					$option["elementoption_id"] = mysql_insert_id();
					$optionsList[$optIndex] = $option;
				}
				$element->setOptions($optionsList);
			}
		}
	}
 }
?>
