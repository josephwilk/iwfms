<?

/* class prologConstructCollection {{{ */
/**
 * The prologConstructCollection class represents a collection prolog data structures. 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package prolog.abstractStructures
 */
/* }}} */


class prologConstructCollection{

	var $constructs = array();
	
	
	function getConstructs(){
		
		return 	$this->constructs;
		
	}
	
	
	function addConstruct($value){
	
		array_push($this->constructs, $value);	
		
	}
	
		
	//Output construct elements as elements in an array
	function toArray(){
		
		$result = array();
		
		$constructsSize = sizeof($this->constructs);
		for($index=0; $index< $constructsSize; $index++){
		
			$result[$index] = $this->constructs[$index]->toString() . '.';
			
		}	
		
		return $result;
		
	}
	
	function toString(){
	
		$result = '';
		
		$constructsSize = sizeof($this->constructs);
		
		for($index=0; $index< $constructsSize; $index++){
		
			$result .= $this->constructs[$index]->toString();
		
			if($index < sizeof($this->constructs)-1){
					$result .= ';';
				
			}
		}	
		
		return $result;
		
	}
	
	function isFact(){
		
		$fact = true;
		
		if( sizeof($this->constructs) ){
		
			$fact = false;
				
		}	
		
		return $fact;
		
	}
	
	
}
?>