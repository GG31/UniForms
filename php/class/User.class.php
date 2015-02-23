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
	}

?>