<?php
	/**
	 * Represents an answer
	 */
	Class Answer {
		
		/**
		 * id of the answer
		 * @access private
		 * @var integer
		 */
		private $id;
		
		/**
		 * id of the previous answer
		 * @access private
		 * @var integer
		 */
		private $prev;
		
		/**
		 * Answer's state, TRUE if sent, FALSE if not
		 * @access private
		 * @var boolean
		 */
		private $state;
		
		/**
		 * 
		 * @var Element
		 */
		private $elementsValues = [];

		/**
		 * Constructor
		 * Create an answer, if already exist fill the attributes from the database
		 * @param integer $id the id's answer default NULL
		 */
		public function __construct($id = NULL){
			global $database;
			if($id !== NULL){
				// Id
				$this->id = $id;

				// Prev, State
				$query = mysqli_query($database, "	SELECT 	*
										FROM 	answer
										WHERE 	answer_id = " . $this->id);

				if (!mysqli_num_rows($query)){
					die("Answer::__construct() : id not found !");
				}else{
					$results = mysqli_fetch_array($query);

					$this->prev 	= $results["answer_prev_id"];
					$this->state 	= $results["answer_status"] 	== 1 ? TRUE : FALSE;
				}

				// ElementsValues
				$query = mysqli_query($database, "	SELECT formelement_id, value
										FROM 			answervalue
												JOIN 	elementanswer
												ON 		elementanswer.elementanswer_id = answervalue.elementanswer_id
										WHERE 	elementanswer.answer_id = " . $this->id . "
										ORDER BY formelement_id");
				
				if (!mysqli_num_rows($query)){
					// TODO uncomment
					// or make it silent, dunno
					// die("Answer::__construct() : values not found !");
				}else{
					$this->elementsValues = [];

					// Values are grouped together if they're multiple
					$results 	= mysqli_fetch_array($query);
					$elementId 	= $results["formelement_id"];
					$values 	= [];
					$values[] 	= $results["value"];

					while($results = mysqli_fetch_array($query)){
						if($results["formelement_id"] == $elementId){
							$values[] = $results["value"];
						}else{
							$this->elementsValues[] = [
								"elementId" => $elementId,
								"values" => $values
							];
							$elementId 	= $results["formelement_id"];
							$values 	= [];
							$values[] 	= $results["value"];
						}
					}

					$this->elementsValues[] = [
						"elementId" => $elementId,
						"values" => $values
					];
				}
			}
		}

		/**
		 * Get and set the form's id
		 * @param integer $id the id's answer default NULL
		 * @return integer
		 */
		public function id($id = NULL){
			// Get
			if($id === NULL){
				return $this->id;
			}
			// Set
			else{
				$this->id = $id;
				return $this;
			}
		}
		
		/**
		 * Get and set the answer's state
   		 * @param integer $state
		 * @return boolean TRUE (validated) or FALSE(not validated yet)
		 */
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

		/**
		 * Get and set the previous answer's id
		 * @param integer $formId the id of the associated form
		 * @return boolean TRUE (validated) or FALSE(not validated yet)
		 */
		public function prev($prev = NULL){
			// Get
			if($prev === NULL){
				return $this->prev;
			}
			// Set
			else{
				$this->prev = $prev;
				return $this;
			}
		}

		public function elementsValues($elementsValues = NULL){
			// Get
			if($elementsValues === NULL){
				return $this->elementsValues;
			}
			// Set
			else{
				$this->elementsValues = $elementsValues;
				return $this;
			}
		}

		public function values($elemId){
			$ret = [];
			// var_dump($this->elementsValues);
			foreach($this->elementsValues as $elementValues){
				if($elementValues["elementId"] == $elemId){
					$ret = $elementValues["values"];
					break;
				}
			}

			return $ret;
		}

		public function userId(){
			global $database;
			$ret = "";

			$query = mysqli_query($database, "	SELECT user_id
									FROM 			answer
											JOIN 	formdest
											ON 		answer.formdest_id = formdest.formdest_id
									WHERE 	answer.answer_id = " . $this->id);
			
			if (!mysqli_num_rows($query)){
				die("Answer::userId() : user not found !");
			}else{
				$ret = mysqli_fetch_array($query)["user_id"];
			}

			return $ret;
		}

		public function formId(){
			global $database;
			$ret = "";

			$query = mysqli_query($database, "	SELECT form_id
									FROM 			formgroup
											JOIN 	(
														formdest
												JOIN 	answer
												ON 		formdest.formdest_id = answer.formdest_id
											)
											ON 		formdest.formgroup_id = formgroup.formgroup_id
									WHERE 	answer.answer_id = " . $this->id);
			
			if (!mysqli_num_rows($query)){
				die("Answer::formId() : form not found !");
			}else{
				$ret = mysqli_fetch_array($query)["form_id"];
			}

			return $ret;
		}

		/**
		 * Saves answer in the database
		 * @param Form $formdestId
		 */
		public function save($formdestId){
			global $database;
			// Create answer
			if($this->id === NULL){
				mysqli_query($database, "INSERT INTO answer(
											answer_status,
											formdest_id,
											answer_prev_id)
									VALUES (
											0," .				// answer_status
											$formdestId . "," .	// formdest_id
											$this->prev .		// answer_prev_id
											")")
				or die("Answer::save() can't create answer : " . mysqli_error($database));

				// Auto generated id
				$this->id = mysqli_insert_id($database);
			}
			// Update answer
			else{
				// Delete values
				mysqli_query($database, "	DELETE FROM elementanswer
								WHERE 		answer_id = " . $this->id)
				or die("Answer::save() can't update answer : " . mysqli_error($database));
			}
			
			// Create values
			foreach($this->elementsValues as $elementValues){
				mysqli_query($database, "	INSERT INTO elementanswer(
												formelement_id,
												answer_id)
										VALUES (" .
											$elementValues["elementId"] . "," .	// formelement_id
											$this->id . ")")					// answer_id
				or die("Answer::save() can't create elementanswer : " . mysqli_error($database));

				$elementAnswerId = mysqli_insert_id($database);
				$arr = $elementValues["values"];
				foreach($arr as $value){
					mysqli_query($database, "	INSERT INTO answervalue(
													value,
													elementanswer_id)
											VALUES('" .
												mysqli_real_escape_string($database, $value) . "'," .	// value
												$elementAnswerId . ")")									// elementanswer_id
					or die("Answer::save() can't create answervalue : " . mysqli_error($database));
				}
			}
		}

		/**
		 * save() and update status to TRUE
		 * @param Form $formdestId
		 */
		public function send($formdestId) {
			global $database;
			$this->save($formdestId);
			$this->state = TRUE;

			// Update status
			mysqli_query($database, "	UPDATE 	answer
							SET 	answer_status = 1
							WHERE 	answer_id = " . $this->id)
			or die("Answer::send() can't update status : " . mysqli_error($database));
		}
		
		/**
		 * Delete all registers related to an answer and in the tables formdest, elementanswer, answervalue
		 */
		public function delete(){
			global $database;
			// Delete answer (DELETE CASCADE)
			mysqli_query($database, "	DELETE FROM answer
							WHERE 		answer_id = ".$this->id)
			or die("Answer::delete() can't delete answer : " . mysqli_error($database));
		}
	}

?>