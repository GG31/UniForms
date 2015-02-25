<?php
	
	// Constants
	define("ELEMENT_TEXT"		, 1);
	define("ELEMENT_NUMBER"		, 2);
	define("ELEMENT_TIME"		, 3);
	define("ELEMENT_DATE"		, 4);
	define("ELEMENT_PHONE"		, 5);
	define("ELEMENT_MULTIPLE"	, 6);
	define("ELEMENT_UNIQUE"		, 7);
	define("ELEMENT_AREA"		, 8);
	define("ELEMENT_SPAN"		, 9);
	define("ELEMENT_SQUARE"		, 10);
	define("ELEMENT_CIRCLE"		, 11);
	define("ELEMENT_IMG"		, 12);
	
	define("DIR_HORIZONTAL"		, 0);
	define("DIR_VERTICAL"		, 1);
	
	Class Element {
		private $id;
		private $type;
		private $label;
		private $x;
		private $y;
		private $height = NULL;
		private $width = NULL;
		private $defaultValue;
		private $placeholder;
		private $min = NULL;
		private $max = NULL;
		private $required = 0;
		private $bigList = 0;
		private $direction = 0;
		private $options = [];
		private $img;

		public function __construct($id = NULL){
			if ($id !== NULL){
				// Id
				$this->id = $id;

				// Every attr except for options
				$query = mysql_query("	SELECT *
										FROM 	formelement 
										WHERE 	formelement_id = " . $this->id);

				if(!mysql_num_rows($query)){
					die("Element::__construct() : id not found !");
				}else{
					$results = mysql_fetch_array($query);
					
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
				$query = mysql_query("	SELECT 		*
										FROM 		elementoption
										WHERE 		formelement_id = " . $this->id . "
										ORDER BY 	optionorder, optionvalue");
				
				if (!mysql_num_rows($query)){
					// Fail silently : elements may not have options
				}else{
					$this->options = [];
					while($results = mysql_fetch_array($query)){
						$this->options[] = [
							"order" 	=> $results["optionorder"],
							"value" 	=> $results["optionvalue"],
							"default" 	=> $results["optiondefault"] 
						];
					}
				}
			}
		}

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
		
		public function save($groupId){
			// Create element
			mysql_query("INSERT INTO formelement(
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
			or die("Element::save() can't save element : " . mysql_error());
			
			// Auto generated id
			$this->id = mysql_insert_id();
			
			// Insert options
			if (is_array($this->options)){
				foreach ($this->options as $option){
					mysql_query("INSERT INTO elementoption(
												formelement_id,
												optionorder,
												optionvalue,
												optiondefault)
										VALUES ("
											. 		$this->id 						. ","	// formelement_id
											. 		$option["order"] 				. ","	// optionorder
											. "'" . $option["value"] 				. "',"	// optionvalue
											. 	   ($option["default"] ? 1 : 0) 	. ")")	// optiondefault
					or die("Element::save() can't save option : " . mysql_error());
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
