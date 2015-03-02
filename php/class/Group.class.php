<?php
	
	Class Group {
		private $id;
		private $limit;
		private $elements;
		private $users;
		private $answers;

		public function __construct($id = NULL){
			global $database;
			if ($id !== NULL){
				// Id
				$this->id = $id;

				// Limit
				$query = mysqli_query($database, "	SELECT 	group_limit
										FROM 	formgroup
										WHERE 	formgroup_id = " . $this->id);

				if (!mysqli_num_rows($query)){
					die("Group::__construct() : id not found !");
				}else{
					$results = mysqli_fetch_array($query);

					$this->limit = $results["group_limit"];
				}

				// Elements
				$query = mysqli_query($database, "	SELECT 	*
										FROM 	formelement
										WHERE 	formgroup_id = " . $this->id);

				if (!mysqli_num_rows($query)){
					$this->elements = [];
				}else{
					$this->elements = [];

					while($results = mysqli_fetch_array($query)){
						$this->elements[] = new Element($results["formelement_id"]);
					}
				}

				// Users and Answers
				$query = mysqli_query($database, "	SELECT 		user_id, formdest_id
										FROM 		formdest
										WHERE 		formgroup_id = " . $this->id);

				if (!mysqli_num_rows($query)){
					$this->users 	= [];
					$this->answers 	= [];
				}else{
					$this->users 	= [];
					$this->answers 	= [];

					while($results = mysqli_fetch_array($query)){
						$this->users[] = new User($results["user_id"]);
						$this->answers[$results["user_id"]] = [];

						$query2 = mysqli_query($database, "	SELECT 		answer_id
												FROM 		answer
												WHERE 		formdest_id = " . $results["formdest_id"] . "
												ORDER BY 	answer_id");

						if (!mysqli_num_rows($query2)){
							// Fail silently : user may not have answers yet
						}else{
							while($results2 = mysqli_fetch_array($query2)){
								$this->answers[$results["user_id"]][] = new Answer($results2["answer_id"]);
							}
						}
					}
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

		public function formdestId($userId){
			global $database;
			$ret = "";

			$query = mysqli_query($database, "	SELECT 	formdest_id
									FROM 			formgroup
											JOIN 	formdest
											ON 		formgroup.formgroup_id = formdest.formgroup_id
									WHERE 	user_id = " . $userId . "
									AND 	formgroup.formgroup_id = " . $this->id);

			if (!mysqli_num_rows($query)){
				die("Group::formdestId() : formdest_id not found !");
			}else{
				$results = mysqli_fetch_array($query);

				$ret = $results["formdest_id"];
			}

			return $ret;
		}

		public function in($formdestId = NULL, $ansId = NULL){
			global $database;
			$ret = FALSE;

			if($formdestId !== NULL){
				$query = mysqli_query($database, "	SELECT 	formgroup_id
										FROM 	formdest
										WHERE 	formdest_id = " . $formdestId);

				if (!mysqli_num_rows($query)){
					die("Group::in() (1) : formgroup_id not found !");
				}else{
					$results = mysqli_fetch_array($query);

					$ret = $this->id == $results["formgroup_id"];
				}
			}

			if($ansId !== NULL){
				$query = mysqli_query($database, "	SELECT 	formgroup_id
										FROM 			formdest
												JOIN 	answer
												ON 		answer.formdest_id = formdest.formdest_id
										WHERE 	answer_id = " . $ansId);

				if (!mysqli_num_rows($query)){
					die("Group::in() (2) : formgroup_id not found !");
				}else{
					$results = mysqli_fetch_array($query);

					$ret = $this->id == $results["formgroup_id"];
				}
			}

			return $ret;
		}

		public function save($formId){
			global $database;
			// Insert group
			mysqli_query($database, "INSERT INTO formgroup(
										form_id,
										group_limit)
								VALUES(" . 
										$formId . "," .			// form_id
										$this->limit . ")")		// group_limit
			or die("Group::save() can't create group : " . mysqli_error($database));

			// Auto generated id
			$this->id = mysqli_insert_id($database);
			
			// Insert recipients
			foreach ($this->users as $user){
				mysqli_query($database, "INSERT INTO formdest(
											formgroup_id,
											user_id)
										VALUES("
											. $this->id . ","				// formgroup_id
											. $user->id() . ")")			// user_id
				or die("Group::save() can't insert recipients : " . mysqli_error($database));
			}
			
			// Insert elements
			foreach ($this->elements as $element){
				$element->save($this->id);
			}
		}

		static function delete($formId){
			global $database;
			// DELETE CASCADE : formdest, formelements and answers
			mysqli_query($database, "	DELETE FROM formgroup
										WHERE 		form_id = " . $formId)
			or die("Group::delete() can't delete group : " . mysqli_error($database));
		}
	}
?>