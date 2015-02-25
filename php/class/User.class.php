<?php
	
	Class User {
		private $id;
		private $name;

		public function __construct($id = NULL){
			// Id
			$this->id = $id;

			// Name
			$query = mysql_query("	SELECT 	*
									FROM 	user
									WHERE 	user_id = " . $this->id);

			if (!mysql_num_rows($query)){
				die("User::__construct() : id not found !");
			}else{
				$results = mysql_fetch_array($query);

				$this->name = $results["user_name"];
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

		public function created() {
			$query = mysql_query("	SELECT 	form_id
									FROM 	form
									WHERE 	user_id = " . $this->id)
			or die("User::created() : user not found !");

			$res = [];
			while($line = mysql_fetch_array($query)){
				$res[] = new Form($line["form_id"]);
			}

			return $res;
		}

		public function recipient() {
			$query = mysql_query("	SELECT DISTINCT form_id
									FROM 			formdest
											JOIN	formgroup
											ON 		formdest.formgroup_id = formgroup.formgroup_id
									WHERE 	user_id = " . $this->id)
			or die("User::recipient() : user not found !");

			$res = [];
			while($line = mysql_fetch_array($query)){
				$form = new Form($line["form_id"]);

				if($form->state()){
					$res[] = $form;
				}
			}

			return $res;
		}

		public function isCreator($formId){
			// TODO
			return FALSE;
		}
	}

?>