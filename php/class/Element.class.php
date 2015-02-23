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
	
	Class Element {
		private $id;
		private $type;
		private $label;
		private $x;
		private $y;
		private $height;
		private $width;
		private $default;
		private $placeholder;
		private $min;
		private $max;
		private $required;
		private $big;
		private $direction;
		private $options;
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
					$this->default 		= $results["default_value"];
					$this->placeholder 	= $results["placeholder"];
					$this->max 			= $results["max_value"];
					$this->min 			= $results["min_value"];
					$this->required 	= $results["required"] 	== 1 ? TRUE : FALSE;
					$this->big 			= $results["isbiglist"] == 1 ? TRUE : FALSE;
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
					"type" 				=> $this->type,
					"label"				=> $this->label,
					"x" 				=> $this->x,
					"y" 				=> $this->y,
					"width" 			=> $this->width,
					"height" 			=> $this->height,
					"default" 			=> $this->default,
					"placeholder" 		=> $this->placeholder,
					"min"	 			=> $this->min,
					"max"	 			=> $this->max,
					"required" 			=> $this->required,
					"big" 				=> $this->big,
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

				if(isset($attr["type"]))			$this->type			= $attr["type"];
				if(isset($attr["label"]))			$this->label 		= $attr["label"];
				if(isset($attr["x"]))				$this->x 			= $attr["x"];
				if(isset($attr["y"]))				$this->y 			= $attr["y"];
				if(isset($attr["height"]))			$this->height 		= $attr["height"];
				if(isset($attr["width"]))			$this->width 		= $attr["width"];
				if(isset($attr["default"]))			$this->default 		= $attr["default"];
				if(isset($attr["placeholder"]))		$this->placeholder 	= $attr["placeholder"];
				if(isset($attr["min"]))				$this->min 			= $attr["min"];
				if(isset($attr["max"]))				$this->max 			= $attr["max"];
				if(isset($attr["required"]))		$this->required		= $attr["required"];
				if(isset($attr["big"]))				$this->big 			= $attr["big"];
				if(isset($attr["direction"]))		$this->direction 	= $attr["direction"];
				if(isset($attr["options"]))			$this->options 		= $attr["options"];
				if(isset($attr["img"]))				$this->img 			= $attr["img"];

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
									. 		$groupId 					. ","	// formgroup_id
									. 		$this->type 				. ","	// type_this
									. "'" . $this->label 				. "',"	// label
									. 		$this->x 					. ","	// pos_x
									. 		$this->y 					. ","	// pos_y
									. 		$this->height				. ","	// height
									. 		$this->width 				. ","	// width
									. "'" . $this->default 				. "',"	// default_value
									. "'" . $this->placeholder			. "',"	// placeholder
									. 		$this->min 					. ","	// min_value
									. 		$this->max 					. ","	// max_value
									. 	   ($this->required ? 1 : 0) 	. ","	// required
									. 	   ($this->big 		? 1 : 0) 	. ","	// isbiglist
									.	   ($this->direction? 1 : 0)	. ","	// direction
									.		$this->img 					. ")")	// img
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
