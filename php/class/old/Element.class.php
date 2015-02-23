<?php
/**
 * Represents an element of a form
 */
class Element {

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
			}
		}
	}
	
	/**
	 * Give the element's id
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get all the element's attributes !
	 * @return array of attributes
	 */
	public function getAll(){
		return 	[
					"id" 				=> $this->getId(),
					"type" 				=> $this->getTypeElement(),
					"x" 				=> $this->getX(),
					"y" 				=> $this->getY(),
					"minvalue" 			=> $this->getMinvalue(),
					"maxvalue" 			=> $this->getMaxvalue(),
					"default" 			=> $this->getDefaultValue(),
					"required" 			=> $this->getRequired(),
					"width" 			=> $this->getWidth(),
					"height" 			=> $this->getHeight(),
					"placeholder" 		=> $this->getPlaceholder(),
					"direction" 		=> $this->getDirection(),
					"big" 				=> $this->getIsbiglist(),
					"options" 			=> $this->getOptions(),
					"label"				=> $this->getLabel()
				];
	}

	
	/**
    * Set any attribute
    * @param array(s) : ["attributeName" => "attributeValue", "attributeName" => "attributeValue", ...]
    */
	public function set(){
		$num = func_num_args();
		$args = func_get_args();
		$attributes = $args[0];

		for ($i=1; $i < $num; $i++) { 
			$attributes = array_merge($attributes, $args[$i]);
		}

		if( isset( $attributes["type"] 			) )			$this->setTypeElement	( $attributes["type"] 		);
		if( isset( $attributes["x"] 			) )			$this->setX 			( $attributes["x"] 			);
		if( isset( $attributes["y"] 			) )			$this->setY 			( $attributes["y"] 			);
		if( isset( $attributes["minvalue"] 		) )			$this->setMinvalue		( $attributes["minvalue"] 	);
		if( isset( $attributes["maxvalue"] 		) )			$this->setMaxvalue		( $attributes["maxvalue"] 	);
		if( isset( $attributes["default"] 		) )			$this->setDefaultValue	( $attributes["default"] 	);
		if( isset( $attributes["required"] 		) )			$this->setRequired		( $attributes["required"] 	);
		if( isset( $attributes["width"] 		) )			$this->setWidth			( $attributes["width"]	 	);
		if( isset( $attributes["height"] 		) )			$this->setWidth			( $attributes["height"]		);
		if( isset( $attributes["placeholder"] 	) )			$this->setPlaceholder 	( $attributes["placeholder"]);
		if( isset( $attributes["direction"] 	) )			$this->setDirection 	( $attributes["direction"]	);
		if( isset( $attributes["big"]		 	) )			$this->setIsbiglist 	( $attributes["big"]		);
		if( isset( $attributes["options"]	 	) )			$this->setOptions 	 	( $attributes["options"]	);
		if( isset( $attributes["label"]		 	) )			$this->setLabel 	 	( $attributes["label"]		);
	}
	
	/**
	 * Give the element's type
	 * @return integer
	 */
	public function getTypeElement() {
		return $this->typeElement;
	}
	
	/**
	 * Give the x position
	 * @return integer
	 */
	public function getX() {
		return $this->x;
	}
	
	/**
	 * Give the y position
	 * @return integer
	 */
	public function getY() {
		return $this->y;
	}
	
	/**
	 * Give the default value
	 * @return string
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}
	
	/**
	 * Returns true if form is anonymous
	 * @return boolean
	 */
	public function getRequired() {
		return $this->required;
	}
	
	/**
	 * Give the width
	 * @return integer
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 * Give the height
	 * @return integer
	 */
	public function getHeight() {
		return $this->height;
	}
	
	/**
	 * Give the placeholder
	 * @return string
	 */
	public function getPlaceholder() {
		return $this->placeholder;
	}
	
	/**
	 * Give the direction that options are shown (1 - vertical or  0 - horizontal)
	 * @return integer
	 */
	public function getDirection() {
		return $this->direction;
	}
	
	/**
	 * Returns true if the list of options is big
	 * @return boolean
	 */
	public function getIsbiglist() {
		return $this->isbiglist;
	}
	
	/**
	 * Returns the options of the element.
	 * @return array of array. for each option there is an array with four values: "elementoption_id" "value" "order" "default". (see constructor...)
	 */
	public function getOptions() {
		return $this->optionsList;
	}
	/**
	 * Returns the max value allowed
	 * @return integer
	 */
	 
	public function getMaxvalue() {
		return $this->maxvalue;
	}

	/**
	 * Returns the min value allowed
	 * @return integer
	 */
	public function getMinvalue() {
		return $this->minvalue;
	}

	/**
	 * Returns the label
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
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

	/**
    * Sets the y position 
    * @param integer $y
    */
	public function setY($y){
		$this->y = $y;
	}
	
	/**
    * Sets the default value
    * @param string $value
    */
	public function setDefaultValue($value){
		$this->defaultValue = $value;
	}
	
	/**
    * Sets if the element is required
    * @param boolean $required
    */
	public function setRequired($required){
		$this->required = $required;
	}
	
	/**
    * Sets the width
    * @param integer $width
    */
	public function setWidth($width){
		$this->width = $width;
	}
	
	/**
    * Sets the height
    * @param integer $height
    */
	public function setHeight($height){
		$this->height = $height;
	}
	
	/**
    * Sets the placeholder
    * @param string $placeholder
    */
	public function setPlaceholder($placeholder){
		$this->placeholder = $placeholder;
	}
	
	/**
    * Sets the direction
    * @param integer $direction
    */
	public function setDirection($direction){
		$this->direction = $direction;
	}
	
	/**
    * Sets if the list big
    * @param boolean $bigList
    */
	public function setIsbiglist($bigList){
		$this->isbiglist = $bigList;
	}
	
	/**
    * Sets the element's options
    * @param array of array $options. for each option must exist an array with: "value" "order" "default". 
    */
	public function setOptions($options){
		$this->optionsList = $options;
	}
	
	/**
    * Sets the max value allowed
    * @param integer $maxvalue
    */
	public function setMaxvalue($maxvalue){
		$this->maxvalue = $maxvalue;
	}
	
	/**
    * Sets the min value allowed
    * @param integer $minvalue
    */
	public function setMinvalue($minvalue){
		$this->minvalue = $minvalue;
	}
	
}

// to use this do constant("nameoftheconstant"), ex: constant("typeRadioButton") returns 3
define("typeInputText", 1);
define("typeInputNumber", 2);
define("typeInputTime", 3);
define("typeInputDate", 4);
define("typeInputPhone", 5);
define("typeCheckbox", 6);
define("typeRadioButton", 7);
define("typeTextArea", 8);

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
?>
