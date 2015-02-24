<?php
	
	Class Group {
		private $id;
		private $limit;
		private $elements;
		private $users;
		private $answers;

		public function __construct($id = NULL){
			if ($id !== NULL){
				// Id
				$this->id = $id;

				// Limit
				$query = mysql_query("	SELECT 	group_limit
										FROM 	formgroup
										WHERE 	formgroup_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Group::__construct() : id not found !");
				}else{
					$results = mysql_fetch_array($query);

					$this->limit = $results["group_limit"];
				}

				// Elements
				$query = mysql_query("	SELECT 	*
										FROM 	formelement
										WHERE 	formgroup_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Group::__construct() : elements not found !");
				}else{
					$this->elements = [];

					while($results = mysql_fetch_array($query)){
						$this->elements = new Element($results["formelement_id"]);
					}
				}

				// Users and Answers
				$query = mysql_query("	SELECT 		user_id, formdest_id
										FROM 		formdest
										WHERE 		formgroup_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Group::__construct() : user not found !");
				}else{
					$this->users 	= [];
					$this->answers 	= [];

					while($results = mysql_fetch_array($query)){
						$this->users[] = new User($results["user_id"]);
						$this->answers[$results["user_id"]] = [];

						$query2 = mysql_query("	SELECT 		answer_id
												FROM 		answer
												WHERE 		formdest_id = " . $results["formdest_id"] . "
												ORDER BY 	answer_id");

						if (!mysql_num_rows($query2)){
							// Fail silently : user may not have answers yet
						}else{
							while($results2 = mysql_fetch_array($query2)){
								$this->answers[$results["user_id"]][] = new Answer($results2["answer_id"]);
							}
						}
					}
				}
			}
		}

		public function limit($limit = NULL){
			// Get
			if($limit === NULL){
				return $this->limit;
			}
			// Set
			else{
				$this->limit = $limit;
				return $this;
			}
		}

		public function elements($elements = NULL){
			// Get
			if($elements === NULL){
				return $this->elements;
			}
			// Set
			else{
				$this->elements = $elements;
				return $this;
			}
		}

		public function users($users = NULL){
			// Get
			if($users === NULL){
				return $this->users;
			}
			// Set
			else{
				$this->users = $users;
				return $this;
			}
		}

		public function answers($answers = NULL){
			// Get
			if($answers === NULL){
				return $this->answers;
			}
			// Set
			else{
				$this->answers = $answers;
				return $this;
			}
		}

		public function validAnswers(){
			$ret = [];

			foreach($this->answers as $userId => $answers){
				$ret[$userId] = [];

				foreach($answers as $answer){
					if($answer->state()){
						$ret[$userId][] = $answer;
					}
				}
			}

			return $ret;
		}

		public function save($formId){
			// Insert group
			mysql_query("INSERT INTO formgroup(
										form_id,
										group_limit)
								VALUES(" . 
										$formId . "," .			// form_id
										$this->limit . ")")		// group_limit
			or die("Group::save() can't create group : " . mysql_error());

			// Auto generated id
			$this->id = mysql_insert_id();
			
			// Insert recipients
			foreach ($this->users as $user){
				mysql_query("INSERT INTO formdest(
											formgroup_id,
											user_id)
									VALUES("
										. $this->id . ","				// formgroup_id
										. $user->id() . ")")			// user_id
				or die("Group::save() can't insert recipients : " . mysql_error());
			}
			
			// Insert elements
			foreach ($this->elements as $element){
				$element->save($this->id);
			}
		}

		public function delete(){
			// DELETE CASCADE : formelements and formdest
			mysql_query("	DELETE FROM formgroup
							WHERE 		formgroup_id = " . $this->id)
			or die("Group::delete() can't delete group : " . mysql_error());
		}
	}

?>