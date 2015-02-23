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

		public function __construct($id = NULL){
			if ($id !== NULL){
				// Id
				$this->id = $id;

<<<<<<< HEAD
	/**
	 * type of the element. Use the constants typeCheckbox, typeInput, typeTextArea, typeRadioButton... they are all defined below this class
     * @access private
     * @var integer 
     */
	private $typeElement;
	
	/**
	 * position x of the element
     * @access private
     * @var integer 
     */
	private $x = 0;
	
	/**
	 * position y of the element
     * @access private
     * @var integer 
     */
	private $y = 0;
	
	/**
	 * default value of the field
     * @access private
     * @var string 
     */
	private $defaultValue = "";
	
	/**
	 * defines if it is a required field
     * @access private
     * @var boolean TRUE (required) or FALSE(not required)
     */
	private $required = FALSE;
	
	/**
     * @access private
     * @var integer 
     */
	private $width = 0;
	
	/**
     * @access private
     * @var integer 
     */
	private $height = 0;
	
	/**
     * @access private
     * @var string 
     */
	private $placeholder = "";
	
	/**
	 * direction that options are shown (1 - vertical or  0 - horizontal)
     * @access private
     * @var integer 
     */
	private $direction = 0;
	
	/**
	 * defines if the list of options is big (the representation in paper will be diferent).
     * @access private
     * @var integer 
     */
	private $isbiglist = FALSE;
	
	/**
	 * list of options of this element. array with four fields: elementoption id, option value, option order and option default
     * @access private
     * @var array of options 
     */
	private $optionsList = NULL;
	
	/**
	 * maximum value accepted by the element
     * @access private
     * @var integer 
     */
	private $maxvalue = 0;
	
	/**
	 * minimum value accepted by the element
     * @access private
     * @var integer 
     */
	private $minvalue = 0;
	
	/**
	 * label of the element
     * @access private
     * @var string 
     */
	private $label = '';
	
	/**
	 * image
     * @access private
     * @var string 
     */
	private $img = '';

	/**
	 * Constructor
	 */
	public function __construct($idFormElement = -1) {
		if ($idFormElement != -1){
			$qElement = mysql_query("SELECT * FROM formelement WHERE formelement_id = ".$idFormElement);
			if (! mysql_num_rows ( $qElement )) {
				// Error...
				exit();
			}
			
			$rElement = mysql_fetch_array($qElement);
			
			$this->id = $rElement["formelement_id"];
			$this->typeElement = $rElement["type_element"];
			$this->x = $rElement["pos_x"];
			$this->y = $rElement["pos_y"];
			$this->defaultValue = $rElement["default_value"];
			$this->required = $rElement["required"] == 1 ? TRUE : FALSE;
			$this->width = $rElement["width"];
			$this->height = $rElement["height"];
			$this->placeholder = $rElement["placeholder"];
			$this->direction = $rElement["direction"];
			$this->isbiglist = $rElement["isbiglist"] == 1 ? TRUE : FALSE;
			$this->maxvalue = $rElement["max_value"];
			$this->minvalue = $rElement["min_value"];
			$this->label = $rElement["label"];
			$this->img = $rElement["img"];
			
			$this->optionsList = array();
			$qElementOptions = mysql_query("SELECT * FROM elementoption WHERE formelement_id = ".$idFormElement." ORDER BY optionorder, optionvalue");
			while ($rElementOptions = mysql_fetch_array($qElementOptions)){
				$option = array (
					"elementoption_id" => $rElementOptions ["elementoption_id"],
					"value" => $rElementOptions ["optionvalue"],
					"order" => $rElementOptions ["optionorder"],
					"default" => $rElementOptions ["optiondefault"] 
				);
				array_push ( $this->optionsList, $option );
=======
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
>>>>>>> L4Classes
			}
		}

<<<<<<< HEAD
	//TODO doc, switch type
	public function getAll(){
/**
 * FORMELEMENT :
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
		return 	[
					"id" 			=> $this->getId(),
					"type" 			=> $this->getTypeElement(),
					"x" 			=> $this->getX(),
					"y" 			=> $this->getY(),
					"minvalue" 			=> $this->getMinvalue(),
					"maxvalue" 			=> $this->getMaxvalue(),
					"default" 		=> $this->getDefaultValue(),
					"required" 		=> $this->getRequired(),
					"width" 		=> $this->getWidth(),
					"height" 		=> $this->getHeight(),
					"placeholder" 	=> $this->getPlaceholder(),
					"direction" 	=> $this->getDirection(),
					"big" 			=> $this->getIsbiglist(),
					"options" 		=> $this->getOptions(),
					"label"			=> $this->getLabel(),
					"img"			=> $this->getImg()
=======
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
					"options" 			=> $this->options
>>>>>>> L4Classes
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

<<<<<<< HEAD
	/**
	 * Returns the label
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}
	
	/**
	 * Returns the image
	 * @return string
	 */
	public function getImg() {
		return $this->img;
	}
	
	/**
    * Sets the id 
    * @param integer $id
    */
	public function setId($id){
		$this->id = $id;
	}
	
	/**
    * Sets the label
    * @param string $label
    */
	public function setLabel($label){
		$this->label = $label;
	}
	
	/**
    * Sets the element type 
    * @param integer $type
    */
	public function setTypeElement($type){
		$this->typeElement = $type;
	}
	
	/**
    * Sets the x position 
    * @param integer $x
    */
	public function setX($x){
		$this->x = $x;
	}
=======
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
>>>>>>> L4Classes

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
										direction)
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
									.	   ($this->direction? 1 : 0)	. ")")	// direction
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
<<<<<<< HEAD
	
	/**
    * Sets the image
    * @param string $img
    */
	public function setImg($img){
		$this->img = $img;
	}
	
}

// to use this do constant("nameoftheconstant"), ex: constant("typeRadioButton") returns 7
define("typeInputText", 1);
define("typeInputNumber", 2);
define("typeInputTime", 3);
define("typeInputDate", 4);
define("typeInputPhone", 5);
define("typeCheckbox", 6);
define("typeRadioButton", 7);
define("typeTextArea", 8);
define("typeSpan", 9);
define("typeSquare", 10);
define("typeCircle", 11);
define("typeImage", 12);
=======

>>>>>>> L4Classes
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
