<?

/* class javaScriptCollection {{{ */
/**
 * Represents a collection of JavaScript constraints
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.javaScript
 */
/* }}} */

class javaScriptCollection{

	var $collection;
	
	function javaScriptCollection(){

		$this->collection = array();
		
	}

	function addConstraint($constraintObject){
		
		array_push($this->collection,$constraintObject);	
		
	}
	
	function toJavascriptArray($collectionIndex){
		
		
			
		$resultString = "planCollection[$collectionIndex] = Array();\n";
		
		$arrayCount=0;
		for($index=0; $index < sizeof($this->collection); $index++){
			
			$resultString .=  'planCollection['.$collectionIndex.']['.$arrayCount.']=' . $this->collection[$index]->toString(). ";\n";
			$arrayCount++;
			$resultString .=  'planCollection['.$collectionIndex.']['.$arrayCount.']= "' . $this->collection[$index]->getElementName(). "\";\n";
			$arrayCount++;
		}
		
		return $resultString;
		
	}
	
}

?>