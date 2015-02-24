<?php

	Class Answer {
		private $id;
		private $prev;
		private $state;
		private $elementsValues;

		public function __construct($id = NULL){
			if($id !== NULL){
				// Id
				$this->id = $id;

				// Prev, State
				$query = mysql_query("	SELECT 	*
										FROM 	answer
										WHERE 	answer_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Answer::__construct() : id not found !");
				}else{
					$results = mysql_fetch_array($query);

					$this->prev 	= $results["answer_prev_id"];
					$this->state 	= $results["answer_status"] 	== 1 ? TRUE : FALSE;
				}

				// ElementsValues
				$query = mysql_query("	SELECT formelement_id, value
										FROM 			answervalue
												JOIN 	elementanswer
												ON 		elementanswer.elementanswer_id = answervalue.elementanswer_id
										WHERE 	elementanswer.answer_id = " . $this->id . "
										ORDER BY formelement_id");
				
				if (!mysql_num_rows($query)){
					// TODO uncomment
					// or make it silent, dunno
					// die("Answer::__construct() : values not found !");
				}else{
					$this->elementsValues = [];

					// Values are grouped together if they're multiple
					$results 	= mysql_fetch_array($query);
					$elementId 	= $results["formelement_id"];
					$values 	= [];
					$values[] 	= $results["value"];

					while($results = mysql_fetch_array($query)){
						if($results["formdest_id"] == $elementId){
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

		public function save($userId){
			// Create answer
			if($this->id === NULL){
				mysql_query("INSERT INTO formdest(
											formdest_status,
											user_id,
											formgroup_id)
									VALUES (
											0," .				// formdest_status
											$userId . "," .		// user_id
											$this->id .			// formgroup_id
											")")
				or die("Answer::save() can't create answer : " . mysql_error());

				// Auto generated id
				$this->id = mysql_insert_id();
			}
			// Update answer
			else{
				// Delete values
				mysql_query("	DELETE FROM elementanswer
								WHERE 		formdest_id = " . $this->id)
				or die("Answer::save() can't update answer : " . mysql_error());
			}
			
			// Create values
			foreach($this->elementsValues as $elementValues){
				mysql_query("	INSERT INTO elementanswer(
												formelement_id,
												formdest_id)
										VALUES (" .
											$elementValues["elementId"] . "," .	// formelement_id
											$this->id . ")")					// formdest_id
				or die("Answer::save() can't create elementanswer : " . mysql_error());

				$elementAnswerId = mysql_insert_id();
				foreach($elementValues["values"] as $value){
					mysql_query("	INSERT INTO answervalue(
													value,
													elementanswer_id)
											VALUES('" .
												$value . "'," .				// value
												$elementAnswerId . ")")		// elementanswer_id
					or die("Answer::save() can't create answervalue : " . mysql_error());
				}
			}
		}

		public function send() {
			$this->save();
			$this->state = TRUE;

			// Update status
			mysql_query("	UPDATE formdest
							SET formdest_status = 1
							WHERE formdest_id = " . $this->id)
			or die("Answer::send() can't update status : " . mysql_error());
		}
		
		public function delete(){
			// Delete answer (DELETE CASCADE)
			mysql_query("	DELETE FROM formdest
							WHERE 		formdest_id = ".$this->id)
			or die("Answer::delete() can't delete answer : " . mysql_error());
		}
	}

?>