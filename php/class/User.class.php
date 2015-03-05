<?php
	/**
	 * Represent a user, he has an id and a name.
	 */
	Class User {
		
		/**
		 * Id of this user
		 * @access private
		 * @var integer
		 */
		private $id;
		
		/**
		 * Name of this user
		 * @access private
		 * @var string
		 */
		private $name;
		
		/**
		 * Constructor, create a user
		 * @access public
		 * @param integer $userId the id of the user default NULL
		 */
		public function __construct($id = NULL){
			global $database;
			// Id
			$this->id = $id;
			// Name
			$query = mysqli_query($database, "	SELECT 	* FROM 	user WHERE 	user_id = " . $this->id);

			if (!mysqli_num_rows($query)){
				die("User::__construct() : id not found !");
			}else{
				$results = mysqli_fetch_array($query);

				$this->name = $results["user_name"];
			}
		}

		/**
		 * Get and Set the user's id
		 * @access public
		 * @param integer $id the id's user default NULL
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
		 * Get and Set the user's name
		 * @access public
		 * @param string $name the name's user default NULL
		 * @return string
		 */
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

		/**
		 * Give the forms created by the user
		 * @access public
		 * @return array of Form
		 */
		public function created() {
			global $database;
			$query = mysqli_query($database, "	SELECT 	form_id
									FROM 	form
									WHERE 	user_id = " . $this->id)
			or die("User::created() : user not found !");

			$res = [];
			while($line = mysqli_fetch_array($query)){
				$res[] = new Form($line["form_id"]);
			}

			return $res;
		}

		/**
		 * Give the forms which the user is recipient
		 * @access public
		 * @return array of Form
		 */
		public function recipient() {
			global $database;
			$query = mysqli_query($database, "	SELECT DISTINCT form_id
									FROM 			formdest
											JOIN	formgroup
											ON 		formdest.formgroup_id = formgroup.formgroup_id
									WHERE 	user_id = " . $this->id)
			or die("User::recipient() : user not found !");

			$res = [];
			while($line = mysqli_fetch_array($query)){
				$form = new Form($line["form_id"]);

				if($form->state()){
					$res[] = $form;
				}
			}

			return $res;
		}

		/**
		 * The user is creator of the form formId
		 * @access public
		 * @param integer $formId id's form
		 * @return boolean TRUE (FALSE) if user is (not) creator of form
		 */
		public function isCreator($formId){

			return FALSE;
		}

		/**
		 * Give all users
		 * @static
		 * @return array of User
		 */
		public static function all() {
			global $database;
			$res = [];

			$query = mysqli_query ($database, "	SELECT user_id
												FROM user" )
			or die("User::all() : users not found !");
			
			while ( $results = mysqli_fetch_array ( $query ) ) {
				if ($results ["user_id"] != 0) // User 0 is Anonymous
					$res [] = new User ( $results ["user_id"] );
			}
			
			return $res;
		}
		
		public function isFormIdRecipient($formDestId){
			global $database;
			$query = mysqli_query($database, "SELECT * FROM formdest WHERE formdest_id = ".$formDestId." AND user_id = ".$this->id());
			if (mysqli_num_rows($query)) 
				return true;
			return false;
		}

		public function isLimitReached($formDestId){
			global $database;
			$query = mysqli_query($database, "SELECT * FROM answer WHERE formdest_id = ".$formDestId);
			$limit = mysqli_fetch_array(mysqli_query($database, "SELECT * FROM formgroup JOIN formdest ON formgroup.formgroup_id = formdest.formgroup_id AND formdest_id = ".$formDestId))["group_limit"];
			if (mysqli_num_rows($query) >= $limit and $limit != 0) 
				return true;
			return false;
		}
	}

?>