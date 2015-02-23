<?php
	
	Class Form {
		private $id;
		private $creator;
		private $name;
		private $state;
		private $groups;
		private $tree;
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
											form_printable,
											form_anonymous)
									VALUES ("
										. $this->creator->id() . ","		// user_id
										. "'" . $this->name . "',"			// form_name
										. "0,"								// form_status
										. ($this->print ? 1 : 0) . ", "		// form_printable
										. ($this->anon 	? 1 : 0) . ")")			// form_anonymous
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
		
		/**
	    * Returns a SQL script. This script generates a database and tables containing information related to all validated answers of this form.
		* If the form is not validated returns 0.
		* @return string
	    */	
		public function exportSQL(){
			if($this->state == FALSE or $this->id == NULL)
				return 0;
			
			$DBName = 'form'.$this->getName();
			$sql = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";<br>
					SET time_zone = "+00:00";<br>
					CREATE DATABASE IF NOT EXISTS `'.$DBName.'` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;<br>
					USE `'.$DBName.'`;<br><br>';
					
			$sql .=	"DROP TABLE IF EXISTS `formdest`;<br>
					CREATE TABLE IF NOT EXISTS `formdest` (<br>
					  `formdest_id` int(11) NOT NULL AUTO_INCREMENT,<br>
					  `user_id` int(11) NOT NULL,<br>
					  `formgroup_id` int(11) NOT NULL,<br>
					  PRIMARY KEY (`formdest_id`),<br>
					    KEY `fk_formdest_user1_idx` (`user_id`),<br>
						KEY `fk_formdest_form1_idx` (`formgroup_id`)<br>
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=944; <br>
					<br>
					DROP TABLE IF EXISTS `formgroup`;<br>
					CREATE TABLE IF NOT EXISTS `formgroup` (<br>
					  `formgroup_id` int(11) NOT NULL AUTO_INCREMENT,<br>
					  `form_id` int(11) NOT NULL DEFAULT '0',<br>
					  PRIMARY KEY (`formgroup_id`),<br>
					  KEY `fk_form_formgroup` (`form_id`)<br>
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;<br>
					<br>
					CREATE TABLE IF NOT EXISTS `elementanswer` (<br>
					  `elementanswer_id` int(11) NOT NULL AUTO_INCREMENT,<br>
					  `formelement_id` int(11) NOT NULL,<br>
					  `formdest_id` int(11) NOT NULL,<br>
					  PRIMARY KEY (`elementanswer_id`),<br>
					  KEY `fk_formanswers_formlist1_idx` (`formelement_id`),<br>
					  KEY `fk_formanswers_formdest1_idx` (`formdest_id`)<br>
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;<br>
					";
		
			foreach ($this->formGroups as $group){
				$listReceivers = $group->getFormGroupRecipients([], 1);
				foreach ($listReceivers as $receiver){
					$sql .=	"INSERT INTO `formdest` VALUES(".$receiver["formDestId"].",".$receiver["User"]->getId().",".$group->getId().");<br>";
				}
			}
			
			return $sql;
		}
	}

?>
