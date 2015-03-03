<?php
	
	// Constants
	define("typeInputText"		, 1);
	define("typeInputNumber"	, 2);
	define("typeInputTime"		, 3);
	define("typeInputDate"		, 4);
	define("typeInputPhone"		, 5);
	define("typeCheckbox"		, 6);
	define("typeRadioButton"	, 7);
	define("typeTextArea"		, 8);
	define("typeSpan"			, 9);
	define("typeSquare"			, 10);
	define("typeCircle"			, 11);
	define("typeImage"			, 12);
	
	define("DIR_HORIZONTAL"		, 0);
	define("DIR_VERTICAL"		, 1);
	
	/**
	 * Represents an element of a form
	 */	
	
	Class Element {
		
		/**
		 * @access private
		 * @var integer
		 */
		private $id;
		
		/**
		 * type of the element. Use the constants typeCheckbox, typeInput, typeTextArea, typeRadioButton... they are all defined below this class
		 * @access private
		 * @var integer
		 */
		private $type;
		
		/**
		 * label of the element
		 * @access private
		 * @var string
		 */
		private $label;
		
		/**
		 * position x of the element
		 * @access private
		 * @var integer
		 */
		private $x;
		
		/**
		 * position y of the element
		 * @access private
		 * @var integer
		 */
		private $y;
		
		/**
		 * Height of element
		 * @access private
		 * @var integer
		 */
		private $height = NULL;
		
		/**
		 * Width of element
		 * @access private
		 * @var integer
		 */
		private $width = NULL;
		
		/**
		 * default value of the field
		 * @access private
		 * @var string
		 */
		private $defaultValue;
		
		/**
		 * The placeholder attribute specifies a short hint that describes the expected value of an input field 
		 * (e.g. a sample value or a short description of the expected format).
		 * @access private
		 * @var string
		 */
		private $placeholder;
		
		/**
		 * minimum value accepted by the element
		 * @access private
		 * @var integer
		 */
		private $min = NULL;
		
		/**
		 * maximum value accepted by the element
		 * @access private
		 * @var integer
		 */
		private $max = NULL;
		
		/**
		 * defines if it is a required field
		 * @access private
		 * @var integer 0 (required) or 1(not required)
		 */
		private $required = 0;
		
		/**
		 * defines if the list of options is big (the representation in paper will be diferent).
		 * @access private
		 * @var integer
		 */
		private $bigList = 0;
		
		/**
		 * direction that options are shown (1 - vertical or  0 - horizontal)
		 * @access private
		 * @var integer
		 */
		private $direction = 0;
		
		/**
		 * list of options of this element. array with four fields: elementoption id, option value, option order and option default
		 * @access private
		 * @var array of options
		 */
		private $options = [];
		
		/**
		 * defines if it is a image
		 * @access private
		 * @var string
		 */
		private $img;

		/**
		 * Constructor
		 * @param string $id
		 */
		public function __construct($id = NULL){
			global $database;
			if ($id !== NULL){
				// Id
				$this->id = $id;

				// Every attr except for options
				$query = mysqli_query($database, "	SELECT *
										FROM 	formelement 
										WHERE 	formelement_id = " . $this->id);

				if(!mysqli_num_rows($query)){
					die("Element::__construct() : id not found !");
				}else{
					$results = mysqli_fetch_array($query);
					
					$this->type 		= $results["type_element"];
					$this->label 		= $results["label"];
					$this->x 			= $results["pos_x"];
					$this->y 			= $results["pos_y"];
					$this->height 		= $results["height"];
					$this->width 		= $results["width"];
					$this->defaultValue	= $results["default_value"];
					$this->placeholder 	= $results["placeholder"];
					$this->max 			= $results["max_value"];
					$this->min 			= $results["min_value"];
					$this->required 	= $results["required"] 	== 1 ? TRUE : FALSE;
					$this->bigList		= $results["isbiglist"] == 1 ? TRUE : FALSE;
					$this->direction 	= $results["direction"] == 1 ? TRUE : FALSE;
					$this->img 			= $results["img"];
				}
				
				// Options
				$query = mysqli_query($database, "	SELECT 		*
										FROM 		elementoption
										WHERE 		formelement_id = " . $this->id . "
										ORDER BY 	optionorder, optionvalue");
				
				if (!mysqli_num_rows($query)){
					// Fail silently : elements may not have options
				}else{
					$this->options = [];
					while($results = mysqli_fetch_array($query)){
						$this->options[] = [
							"elementoption_id" 	=> $results["elementoption_id"],
							"order" 	=> $results["optionorder"],
							"value" 	=> $results["optionvalue"],
							"default" 	=> $results["optiondefault"] 
						];
					}
				}
			}
		}

		/**
		 * Get and Set all the element's attributes !
		 * @return array of attributes
		 */
		public function attr(){
			$num = func_num_args();

			// Get
			if($num === 0){
				return 	[
					"id" 				=> $this->id,
					"type" 				=> $this->type,
					"label"				=> $this->label,
					"x" 				=> $this->x,
					"y" 				=> $this->y,
					"width" 			=> $this->width,
					"height" 			=> $this->height,
					"default" 			=> $this->defaultValue,
					"placeholder" 		=> $this->placeholder,
					"min"	 			=> $this->min,
					"max"	 			=> $this->max,
					"required" 			=> $this->required,
					"big" 				=> $this->bigList,
					"direction" 		=> $this->direction,
					"options" 			=> $this->options,
					"img" 				=> $this->img
				];
			}
			// Set
			else{
				// Merge inputs
				$args = func_get_args();
				$attr = $args[0];

				for ($i=1; $i < $num; $i++) { 
					$attr = array_merge($attr, $args[$i]);
				}

				if(isset($attr["id"]))				$this->id			= $attr["id"];
				if(isset($attr["type"]))			$this->type			= $attr["type"];
				if(isset($attr["label"]))			$this->label 		= $attr["label"];
				if(isset($attr["x"]))				$this->x 			= $attr["x"];
				if(isset($attr["y"]))				$this->y 			= $attr["y"];
				if(isset($attr["height"]))			$this->height 		= $attr["height"];
				if(isset($attr["width"]))			$this->width 		= $attr["width"];
				if(isset($attr["defaultValue"]))	$this->defaultValue = $attr["defaultValue"];
				if(isset($attr["placeholder"]))		$this->placeholder 	= $attr["placeholder"];
				if(isset($attr["min"]))				$this->min 			= $attr["min"];
				if(isset($attr["max"]))				$this->max 			= $attr["max"];
				if(isset($attr["required"]))		$this->required		= $attr["required"];
				if(isset($attr["bigList"]))			$this->bigList 		= $attr["bigList"];
				if(isset($attr["direction"]))		$this->direction 	= $attr["direction"];
				if(isset($attr["options"]))			$this->options 		= $attr["options"];
				if(isset($attr["img"]))				$this->img 			= $attr["img"];

				return $this;
			}
		}
		
		/**
		 * Get and Set the element's id
		 * @param integer $id
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
		 * Get and Set the element's type
		 * @param integer $type
		 * @return integer
		 */
		public function type($type = NULL){
			// Get
			if($type === NULL){
				return $this->type;
			}
			// Set
			else{
				$this->type = $type;
				return $this;
			}
		}
		
		/**
		 * Get and Set the label
		 * @param string $label
		 * @return string
		 */
		public function label($label = NULL){
			// Get
			if($label === NULL){
				return $this->label;
			}
			// Set
			else{
				$this->label = $label;
				return $this;
			}
		}
		
		/**
		 * Get and Set the x position
		 * @param integer $x
		 * @return integer
		 */
		public function x($x = NULL){
			// Get
			if($x === NULL){
				return $this->x;
			}
			// Set
			else{
				$this->x = $x;
				return $this;
			}
		}
		
		/**
		 * Get and Ser the y position
		 * @param integer $y
		 * @return integer
		 */
		public function y($y = NULL){
			// Get
			if($y === NULL){
				return $this->y;
			}
			// Set
			else{
				$this->y = $y;
				return $this;
			}
		}
		
		/**
		 * Get and Set the min value allowed
		 * @param integer $min
		 * @return integer
		 */
		public function min($min = NULL){
			// Get
			if($min === NULL){
				return $this->min;
			}
			// Set
			else{
				$this->min = $min;
				return $this;
			}
		}
		
		/**
		 * Get and Set the max value allowed
		 * @param integer $max
		 * @return integer
		 */
		public function max($max = NULL){
			// Get
			if($max === NULL){
				return $this->max;
			}
			// Set
			else{
				$this->max = $max;
				return $this;
			}
		}
		
		/**
		 * Get and Set the width
		 * @param integer $width
		 * @return integer
		 */
		public function width($width = NULL){
			// Get
			if($width === NULL){
				return $this->width;
			}
			// Set
			else{
				$this->width = $width;
				return $this;
			}
		}
		
		/**
		 * Get and Set the height
		 * @param integer $height
		 * @return integer
		 */
		public function height($height = NULL){
			// Get
			if($height === NULL){
				return $this->height;
			}
			// Set
			else{
				$this->height = $height;
				return $this;
			}
		}
		
		/**
		 * Get and Set the default value
		 * @param string $defaultvalue
		 * @return string
		 */
		public function defaultValue($defaultValue = NULL){
			// Get
			if($defaultValue === NULL){
				return $this->defaultValue;
			}
			// Set
			else{
				$this->defaultValue = $defaultValue;
				return $this;
			}
		}
		
		/**
		 * Get and Ser the placeholder
		 * @param string $placeholder
		 * @return string
		 */
		public function placeholder($placeholder = NULL){
			// Get
			if($placeholder === NULL){
				return $this->placeholder;
			}
			// Set
			else{
				$this->placeholder = $placeholder;
				return $this;
			}
		}
		
		/**
		 * Get and Set if the element is required
		 * @param boolean $required
		 * @return boolean
		 */
		public function required($required = NULL){
			// Get
			if($required === NULL){
				return $this->required;
			}
			// Set
			else{
				$this->required = $required;
				return $this;
			}
		}
		
		/**
		 * Get and Set if the element is image
		 * @param boolean $required
		 * @return boolean
		 */
		public function img($img = NULL){
			// Get
			if($img === NULL){
				return $this->img;
			}
			// Set
			else{
				$this->img = $img;
				return $this;
			}
		}
		
		/**
		 * Get and Set if the list big
		 * @param boolean $bigList
		 * @return boolean
		 */
		public function bigList($bigList = NULL){
			// Get
			if($bigList === NULL){
				return $this->bigList;
			}
			// Set
			else{
				$this->bigList = $bigList;
				return $this;
			}
		}
		
		/**
		 * Get and Set the direction
		 * @param integer $direction
		 * @return integer
		 */
		public function direction($direction = NULL){
			// Get
			if($direction === NULL){
				return $this->direction;
			}
			// Set
			else{
				$this->direction = $direction;
				return $this;
			}
		}
		
		/**
		 * Get ans Set the element's options
		 * @param array of array $options. for each option must exist an array with: "value" "order" "default".
		 * @return array
		 */
		public function options($options = NULL){
			// Get
			if($options === NULL){
				return $this->options;
			}
			// Set
			else{
				$this->options = $options;
				return $this;
			}
		}
		
		/**
		 * Save the element on the database
		 * @param Group $groupId
		 */
		public function save($groupId){
			global $database;
			// Create element
			mysqli_query($database, "INSERT INTO formelement(
										formgroup_id,
										type_element,
										label,
										pos_x,
										pos_y,
										height,
										width,
										default_value,
										placeholder,
										min_value,
										max_value,
										required,
										isbiglist,
										direction,
										img)
								VALUES ("
									. 		$groupId 					. ",	
									"  . 	$this->type 				. ",	
									'" . 	$this->label 				. "',	
									"  . 	$this->x 					. ",	
									"  . 	$this->y 					. ",	
									0" . 	$this->height				. ",	
									0" . 	$this->width 				. ",	
									'" . 	$this->defaultValue			. "',	
									'" . 	$this->placeholder			. "',	
									0" . 	$this->min 					. ",	
									0" . 	$this->max 					. ",	
									"  .	($this->required ? 1 : 0) 	. ",	
									"  .  	($this->bigList	? 1 : 0) 	. ",	
									"  .	($this->direction? 1 : 0)	. ",	
									'" . 	$this->img 					. "')")	
			or die("Element::save() can't save element : " . mysqli_error($database));
			
			// Auto generated id
			$this->id = mysqli_insert_id($database);
			
			// Insert options
			if (is_array($this->options)){
				foreach ($this->options as $option){
					mysqli_query($database, "INSERT INTO elementoption(
												formelement_id,
												optionorder,
												optionvalue,
												optiondefault)
										VALUES ("
											. 		$this->id 						. ","	// formelement_id
											. 		$option["order"] 				. ","	// optionorder
											. "'" . $option["value"] 				. "',"	// optionvalue
											. 	   ($option["default"] ? 1 : 0) 	. ")")	// optiondefault
					or die("Element::save() can't save option : " . mysqli_error($database));
				}
			}
		}
	}
?>

<?php
	/**
	 * ELEMENT :
	 * ___________
	 *
	 * all 	: 	lbl, x, y, req, dflt
	 * 
	 * 			wdth 	hght 	plchldr 	dir 	bglst 
	 * txt 	:	x 				x 							
	 * num 	:	x 				x 							
	 * tel 	:	x 				x 							
	 * url 	:	x 				x 							
	 * date	:	x 				x 							
	 * heure:	x 				x 							
	 * $	: 	x 		x 		x 							
	 * radio:								x 		x
	 * scale:								hrztl	 		
	 * chckb:								x 		 		
	 * upld : 												 	
	 *
	 *
	 * ELEMENTOPTION :
	 * _____________
	 *
	 * 			val 	order 	default
	 * radio: 	x 		x 		x
	 * chckb: 	x 		x 		x
	 * scale: 	x 		x 		x
	 * upld : 	mime 	
	 */
?>
