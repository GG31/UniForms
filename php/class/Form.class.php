<?php
	
	Class Form {
		private $id;
		private $creator;
		private $name;
		private $state;
		private $groups;
		private $print;
		private $anon;

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
											form_anonymous,
											form_printable)
									VALUES ("
										. $this->creator->id() . ","		// user_id
										. "'" . $this->name . "',"			// form_name
										. "0,"								// form_status
										. ($this->print ? 1 : 0) . ") "		// form_printable
										. ($this->anon 	? 1 : 0) . ", ")	// form_anonymous
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