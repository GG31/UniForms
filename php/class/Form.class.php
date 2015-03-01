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
			global $database;
			if($id !== NULL){
				// Id
				$this->id = $id;

				// Creator, Name, Status, Print, Anon
				$query = mysqli_query($database, "	SELECT 	*
										FROM 	form
										WHERE 	form_id = " . $this->id);

				if (!mysqli_num_rows($query)){
					die("Form::__construct() : id not found !");
				}else{
					$results = mysqli_fetch_array($query);

					$this->creator 		= new User($results["user_id"]);
					$this->name 		= $results["form_name"];
					$this->state 		= $results["form_status"] 		== 1 ? TRUE : FALSE;
					$this->print 	 	= $results["form_printable"] 	== 1 ? TRUE : FALSE;
					$this->anon 	 	= $results["form_anonymous"] 	== 1 ? TRUE : FALSE;
				}
				
				// Groups
				$query = mysqli_query($database, "	SELECT 		*
										FROM 		formgroup
										WHERE 		form_id = " . $this->id. "
										ORDER BY 	formgroup_id");

				if (!mysqli_num_rows($query)){
					die("Form::__construct() : groups not found !");
				}else{
					$this->groups = [];

					while ($results = mysqli_fetch_array($query)){
						$this->groups[] = new Group($results["formgroup_id"]);
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

		public function tree($userId, $state = FALSE, $groups = NULL){
			$ret = [];

			// Find groups in which the user belongs
			$whichGroups = $groups ? $groups : $this->whichGroups($userId);
			$whichLength = count($whichGroups);

			// For each group, find validated answers in previous groups
			for($i = 0; $i < $whichLength; $i++){
				$g = $whichGroups[$i];
				$group = $this->groups[$g];

				$ret[$g] = [];
				$answers = $group->answers()[$userId];

				// If first group, consider every user's answers
				if($g == 0){
					$ret[$g][0] = $answers;
				}else{
					$prevGroup = $this->groups[$g - 1];
					$valid = $prevGroup->validAnswers(); // Valid set

					// For each answers in the valid set, find if user answered
					foreach($valid as $validAnswers){
						foreach($validAnswers as $validAnswer){
							$ret[$g][$validAnswer->id()] = [];

							foreach($answers as $key => $answer){
								if($answer->prev() == $validAnswer->id()){
									$ret[$g][$validAnswer->id()][] = $answer;
									unset($answers[$key]);
								}
							}
						}
					}
				}

				// Now $ret[$g] contains : ["prevAnsId" => [$ans0, $ans1, ...], ...]
				// Find out if limit is reached
				$lim = $group->limit();
				foreach($ret[$g] as $prevAnsId => $answers){
					if($lim > 0){
						$left = $lim - count($answers);
						$ret[$g][$prevAnsId]["left"] = $left;
					}else{
						$ret[$g][$prevAnsId]["left"] = -1;
					}

					// Filter answers with $state
					foreach ($answers as $key => $answer) {
						if($answer->state() != $state){
							unset($ret[$g][$prevAnsId][$key]);
						}
					}
				}
			}

			return $ret;
		}

		public function whichGroups($userId){
			$ret = [];

			foreach($this->groups as $groupNum => $group){
				if(array_key_exists($userId, $group->answers())){
					$ret[] = $groupNum;
				}
			}

			return $ret;
		}

		public function formdestId($userId, $groupNum){
			$group = $this->groups[$groupNum];

			return $group->formdestId($userId);
		}

		public function chain($ansId){
			if($ansId != 0){
				$ret = [];

				$ans = new Answer($ansId);
				$ret[] = $ans->userId();
				$prev = $ans->prev();

				while($prev != 0){
					$ans = new Answer($prev);
					$ret[] = $ans->userId();
					$prev = $ans->prev();
				}
			}

			$ret[] = $this->creator->id();

			return array_reverse($ret);
		}

		public function done(){
			// TODO !!!!!!!!!!!!!!!!!!!!!!!!!!! ??????
			return false;
		}

		public function getListRecipient($WTF){
			// TODO
			return FALSE;
		}

		public function save() {
			global $database;
			// Create form
			if($this->id === NULL){
				mysqli_query($database, "INSERT INTO form(
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
				$this->id = mysqli_insert_id($database);
			}
			// Update form
			else{
				// Reset form
				mysqli_query($database, "	UPDATE 	form
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
			global $database;
			$this->save();
			$this->state = TRUE;

			// Update status
			mysqli_query($database, "	UPDATE 	form
							SET 	form_status = 1
							WHERE 	form_id 	= " . $this->id)
			or die("Form::send() can't update status : " . mysql_error());
		}

		public function delete(){
			global $database;
			// Delete form (DELETE CASCADE)
			mysqli_query($database, "	DELETE FROM form
							WHERE 		form_id = " . $this->id)
			or die("Form::delete() can't delete form : " . mysql_error());
		}
		
		/**
	    * Creates a file with a SQL script. This script generates a database and tables containing information related to all validated answers of this form.
		* If the form is not validated returns 0, else returns 1.
		* @return int
	    */	
		public function exportSQL(){
			global $database;
			if($this->state == FALSE or $this->id == NULL)
				return 0;
			
			// Get current autoincrement values
			$AIanswer = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'answer';"));
			$AIanswervalue = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'answervalue';"));
			$AIelementanswer = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'elementanswer';"));
			$AIelementoption = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'elementoption';"));
			$AIform = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'form';"));
			$AIformdest = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'formdest';"));
			$AIformelement = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'formelement';"));
			$AIformgroup = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'formgroup';"));
			$AIuser = mysqli_fetch_array(mysqli_query($database, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uniforms' AND TABLE_NAME = 'user';"));

			//$DBName = 'form'.$this->name();
			$DBName = 'ExportedDB';
			
			// Disable constraints and drop, create and select database
			$sql = 'SET FOREIGN_KEY_CHECKS=0;
					DROP DATABASE IF EXISTS `'.$DBName.'`;
					CREATE DATABASE IF NOT EXISTS `'.$DBName.'`;
					USE `'.$DBName.'`;';
			
			// Create all tables
			$sql .=	"DROP TABLE IF EXISTS `answer`;
					CREATE TABLE IF NOT EXISTS `answer` (
					  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
					  `formdest_id` int(11) NOT NULL,
					  `answer_prev_id` int(11) NOT NULL,
					  PRIMARY KEY (`answer_id`),
					  KEY `fk_answer_formdest_idx` (`formdest_id`),
					  CONSTRAINT `fk_answer_formdest_idx` FOREIGN KEY (`formdest_id`) REFERENCES `formdest` (`formdest_id`) ON DELETE CASCADE ON UPDATE NO ACTION
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIanswer["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `answervalue`;
					CREATE TABLE IF NOT EXISTS `answervalue` (
					  `answervalue_id` int(11) NOT NULL AUTO_INCREMENT,
					  `value` varchar(255) DEFAULT NULL,
					  `elementanswer_id` int(11) NOT NULL,
					  PRIMARY KEY (`answervalue_id`),
					  KEY `fk_answervalue_elementanswer1_idx` (`elementanswer_id`),
					  CONSTRAINT `fk_answervalue_elementanswer` FOREIGN KEY (`elementanswer_id`) REFERENCES `elementanswer` (`elementanswer_id`) ON DELETE CASCADE
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIanswervalue["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `elementanswer`;
					CREATE TABLE IF NOT EXISTS `elementanswer` (
					  `elementanswer_id` int(11) NOT NULL AUTO_INCREMENT,
					  `formelement_id` int(11) NOT NULL,
					  `answer_id` int(11) NOT NULL,
					  PRIMARY KEY (`elementanswer_id`),
					  KEY `fk_formanswers_formlist1_idx` (`formelement_id`),
					  KEY `fk_formanswers_answer1_idx` (`answer_id`),
					  CONSTRAINT `fk_formanswers_answer1_idx` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`answer_id`) ON DELETE CASCADE,
					  CONSTRAINT `fk_formanswers_formlist1_idx` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIelementanswer["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `elementoption`;
					CREATE TABLE IF NOT EXISTS `elementoption` (
					  `elementoption_id` int(11) NOT NULL AUTO_INCREMENT,
					  `optionvalue` varchar(255) NOT NULL DEFAULT '0',
					  `formelement_id` int(11) DEFAULT NULL,
					  PRIMARY KEY (`elementoption_id`),
					  KEY `FK_elementoption_formelement` (`formelement_id`),
					  CONSTRAINT `FK_elementoption_formelement` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIelementoption["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `form`;
					CREATE TABLE IF NOT EXISTS `form` (
					  `form_id` int(11) NOT NULL AUTO_INCREMENT,
					  `form_name` varchar(255) DEFAULT NULL,
					  `user_id` int(11) NOT NULL,
					  PRIMARY KEY (`form_id`),
					  KEY `fk_form_user_idx` (`user_id`),
					  CONSTRAINT `fk_form_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIform["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `formdest`;
					CREATE TABLE IF NOT EXISTS `formdest` (
					  `formdest_id` int(11) NOT NULL AUTO_INCREMENT,
					  `user_id` int(11) NOT NULL,
					  `formgroup_id` int(11) NOT NULL,
					  PRIMARY KEY (`formdest_id`),
					  KEY `fk_formdest_user1_idx` (`user_id`),
					  KEY `fk_formdest_form1_idx` (`formgroup_id`),
					  CONSTRAINT `fk_formdest_form1` FOREIGN KEY (`formgroup_id`) REFERENCES `formgroup` (`formgroup_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
					  CONSTRAINT `fk_formdest_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIformdest["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `formelement`;
					CREATE TABLE IF NOT EXISTS `formelement` (
					  `formelement_id` int(11) NOT NULL AUTO_INCREMENT,
					  `type_element` int(11) DEFAULT NULL,
					  `formgroup_id` int(11) NOT NULL,
					  `label` varchar(255) DEFAULT NULL,
					  PRIMARY KEY (`formelement_id`),
					  KEY `fk_formlist_form1_idx` (`formgroup_id`),
					  CONSTRAINT `fk_formgroup_formelement` FOREIGN KEY (`formgroup_id`) REFERENCES `formgroup` (`formgroup_id`) ON DELETE CASCADE
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIformelement["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;

					DROP TABLE IF EXISTS `formgroup`;
					CREATE TABLE IF NOT EXISTS `formgroup` (
					  `formgroup_id` int(11) NOT NULL AUTO_INCREMENT,
					  `form_id` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`formgroup_id`),
					  KEY `fk_form_formgroup` (`form_id`),
					  CONSTRAINT `fk_form_formgroup` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`) ON DELETE CASCADE ON UPDATE NO ACTION
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIformgroup["AUTO_INCREMENT"]." DEFAULT CHARSET=latin1;

					DROP TABLE IF EXISTS `user`;
					CREATE TABLE IF NOT EXISTS `user` (
					  `user_id` int(11) NOT NULL AUTO_INCREMENT,
					  `user_name` varchar(255) DEFAULT NULL,
					  PRIMARY KEY (`user_id`)
					) ENGINE=InnoDB AUTO_INCREMENT=".$AIuser["AUTO_INCREMENT"]." DEFAULT CHARSET=utf8;";
			
			// Insert form into table form
			$sql .=	"INSERT INTO `form` VALUES (".$this->id.", '".$this->name."', ".$this->creator->id().");\r\n";
			
			// Insert creator into table user
			$sql .=	"INSERT INTO `user` VALUES (".$this->creator->id().", '".$this->creator->name()."');\r\n";
			
			// Insert recipients into table user
			$querydests = mysqli_query($database, "SELECT DISTINCT user.user_id, user_name FROM user JOIN (formdest JOIN formgroup 
										ON formdest.formgroup_id = formgroup.formgroup_id AND form_id = ".$this->id.") ON formdest.user_id = user.user_id");
			while ($dests = mysqli_fetch_array($querydests))
				$sql .=	"INSERT INTO `user` VALUES(".$dests["user_id"].",'".$dests["user_name"]."');\r\n";
							
			// Insert groups into table formgroup
			foreach ($this->groups as $group){
				$sql .=	"INSERT INTO `formgroup` VALUES(".$group->id().",".$this->id.");\r\n";
				
				// Insert elements into table formelement
				$elements = $group->elements();
				foreach ($elements as $element){
					$sql .=	"INSERT INTO `formelement` VALUES(".$element->id().",".$element->type().",".$group->id().",'".$element->label()."');\r\n";
					
					// Insert element options into table elementoption
					$queryelemoption = mysqli_query($database, "SELECT * FROM elementoption WHERE formelement_id = ".$element->id());
					while ($options = mysqli_fetch_array($queryelemoption))
						$sql .=	"INSERT INTO `elementoption` VALUES(".$options["elementoption_id"].",'".$options["optionvalue"]."',".$element->id().");\r\n";
				}
				
				// Insert users into table formdest
				$queryformdest = mysqli_query($database, "SELECT * FROM formdest WHERE formgroup_id = ".$group->id());
				while ($users = mysqli_fetch_array($queryformdest)){
					$sql .=	"INSERT INTO `formdest` VALUES(".$users["formdest_id"].",".$users["user_id"].",".$group->id().");\r\n";
					
					// Insert validated answers into table answer
					$queryanswer = mysqli_query($database, "SELECT * FROM answer WHERE answer_status = 1 AND formdest_id = ".$users["formdest_id"]);
					while ($answers = mysqli_fetch_array($queryanswer)){
						$sql .=	"INSERT INTO `answer` VALUES(".$answers["answer_id"].",".$users["formdest_id"].",".$answers["answer_prev_id"].");\r\n";
						
						// Insert into table elementanswer 
						$queryelemanswer = mysqli_query($database, "SELECT * FROM elementanswer WHERE answer_id = ".$answers["answer_id"]);
						while ($elemanswers = mysqli_fetch_array($queryelemanswer)){
							$sql .=	"INSERT INTO `elementanswer` VALUES(".$elemanswers["elementanswer_id"].",".$elemanswers["formelement_id"].",".$elemanswers["answer_id"].");\r\n";
						
							// Insert answer values into table answervalue 
							$queryansvalue = mysqli_query($database, "SELECT * FROM answervalue WHERE elementanswer_id = ".$elemanswers["elementanswer_id"]);
							while ($ansvalues = mysqli_fetch_array($queryansvalue))
								$sql .=	"INSERT INTO `answervalue` VALUES(".$ansvalues["answervalue_id"].",'".$ansvalues["value"]."',".$ansvalues["elementanswer_id"].");\r\n";
						}
					}
				}
			}
			
			// Enable constraints
			$sql .=	"SET FOREIGN_KEY_CHECKS=1;";

			$fileName = "../res/sql/exportSQL.sql";
			//$fileName .= "ExportedForm-".date('Y-m-d_H:i:s').".sql";
			
			$file = fopen($fileName, "c");
			fwrite($file, $sql);
			fclose($file);
		
			return $sql;
		}

	}

?>
