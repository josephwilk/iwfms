<?

/* class XMLtoArray {{{ */
/**
 * Reading an XML file into an array
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package xml
 */
/* }}} */

class XMLtoArray{

	var $file;
	var $parser;
	var $stack = array();
	var $directory = "specifications/xml/";
	
	/**
	* @return XMLtoArray
	* @param $file file specification for XML document
	* @desc Creates a new XMLtoArray object	
 */
	function XMLtoArray( $file = ""){
	
			$this->file = $file;
			
			$this->stack = array(); 
			$this->startElement(null, "root", array()); 
						
	}
	
	
	/**
	* @return void
	* @param $xmlstring XML file as string
	* @desc Parse XML data in string format into an Array struture	
 */
	function parse($xmlstring="") 
	{	 

		$this->parser = xml_parser_create(); 
		xml_set_object($this->parser, $this); 
		
		//Prevent coversion to uppercase
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false); 
		xml_set_element_handler($this->parser, "startElement", "endElement"); 
		xml_set_character_data_handler($this->parser, "characterData"); 

		// parse the data and free the parser... 
		xml_parse($this->parser, $xmlstring); 
		xml_parser_free($this->parser); 
} 
	
	
/**
 * @return void
 * @param $parser XML parser object
 * @param $name XML tag name
 * @param $attrs XML attributes
 * @desc What to do with a XML start tag
 */
function startElement($parser, $name, $attrs) {
   	
	$key ='';
	$value ='';
	$node = array(); 
	$node["_NAME"] = $name; 
	
	foreach ($attrs as $key => $value) { 
		$node[$key] = $value; 
	}
	$node[$key] = $value; 

	$node["_DATA"] = ""; 
	$node["_ELEMENTS"] = array(); 
	
	array_push($this->stack, $node); 
 
}

/**
 * @return void
 * @param $parser XML Parser Object
 * @param $name XML tag name
 * @desc What to do when encountering a end XML tag
 */
function endElement($parser, $name) {
        
       $node = array_pop($this->stack); 
       $node["_DATA"] = trim($node["_DATA"]); 
	   
        array_push( $this->stack[$this->stackSize()-1]["_ELEMENTS"], $node); 
       
}

function stackSize(){

	return count( $this->stack ); 
		
}

/**
 * @return void
 * @param $parser XML Parser Object
 * @param $data String
 * @desc What to do when encountering content within XML tags
 */
function characterData($parser, $data) {
           
    
	$this->stack[$this->stackSize()-1]["_DATA"] .= $data; 
     
}

/**
 * @return Filehandle
 * @desc Open the XML file
 */
function openXML(){

	if (!($fp = fopen( $this->directory . $this->file, "r"))) {
   		
		if(isset($this->file)){
		
			errors::errorMessage("Could not open XML input ". $this->file);
		
		}
		else{
		
			errors::errorMessage("Could not open XML input ");	
			
		}
		
   		return false;
	}
   	return $fp;
}	


/**
 * @return array representing XML file contents
 * @desc Reads the xml file in and parses it
 */
function process(){

	$count=0;
	
	debug::message("XML spec:  ". $this->file . '<br>');
	$fp = XMLtoArray::openXML();
	
	
	
	while ($data = fread($fp, 4096)) {

		debug::message("\n". $data . "\n");
	
			$this->parse($data);
			$count = $count-1;	
	}
   	return($this->stack);
   	
}
}
?>