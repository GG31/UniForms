<?php
	
	Class Group {
		private $id;
		private $limit;
		private $elements;
		private $usersAnswers;

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
					$this->elements = array ();

					while($results = mysql_fetch_array($query)){
						$this->elements = new Element($results["formelement_id"]);
					}
				}

				// Users and Answers
				$query = mysql_query("	SELECT 		user_id
										FROM 		formdest
										WHERE 		formgroup_id = " . $this->id);

				if (!mysql_num_rows($query)){
					die("Group::__construct() : user not found !");
				}else{
					$this->users = [];
					$this->users = 
				}

				// UsersAnswers
				$query = mysql_query("	SELECT 		formdest_id, user_id
										FROM 		formdest
										WHERE 		formgroup_id = " . $this->id . "
										ORDER BY 	user_id, formdest_id");

				if (!mysql_num_rows($query)){
					die("Group::__construct() : answers not found !");
				}else{
					$this->usersAnswers = [];

					// Answers are grouped by Users, ordered chronologically
					$results 	= mysql_fetch_array($query);
					$userId 	= $results["user_id"];
					$answers 	= [];
					$answers[] 	= new Answer($results["formdest_id"]);

					while($results = mysql_fetch_array($query)){
						if($results["user_id"] == $userId){
							$answers[] = new Answer($results["formdest_id"]);
						}else{
							$this->usersAnswers[] = [
								"user" 		=> new User($userId),
								"answers" 	=> $answers
							];
							$userId 	= $results["user_id"];
							$answers 	= [];
							$answers[] 	= new Answer($results["formdest_id"]);
						}
					}

					$this->usersAnswers[] = [
						"user" 		=> new User($userId),
						"answers" 	=> $answers
					];
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

		public function usersAnswers($usersAnswers = NULL){
			// Get
			if($usersAnswers === NULL){
				return $this->usersAnswers;
			}
			// Set
			else{
				$this->usersAnswers = $usersAnswers;
				return $this;
			}
		}

		public function save($formId){
			// Insert group
			mysql_query("INSERT INTO formgroup(
										form_id,
										group_limit)
								VALUES(" . 
										$formId . "," .			// form_id
										$this->limit . ",")		// group_limit
			or die("Group::save() can't create group : " . mysql_error());

			// Auto generated id
			$this->id = mysql_insert_id();
			
			// Inserts recipients & create initial
			foreach ($this->usersAnswers as $userAnswers){
				mysql_query("INSERT INTO formdest(
											formgroup_id,
											user_id,
											formdest_status)
									VALUES("
										. $this->id . ","						// formgroup_id
										. $userAnswers["user"]->id() . ", "		// user_id
										. "-1)")								// formdest_status
				or die("Group::save() can't insert recipients : " . mysql_error());

				// Auto generated id
				$answerId = mysql_insert_id();

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