<?

/* class prologList {{{ */
/**
 * Represents a list in prolog
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package prolog.dataStructures
 */
/* }}} */


class prologList{

	var $listValues = array();
	var $charArray;	
	
	function prologList($string){

		if($string!=''){
		
			if($string[0] == '['){
				
				$string = prologPredicate::__cutOuterBrackets($string);
		
				$vars = prologPredicate::__separateStringPredicateVars($string);
					
				$this->listValues = prologPredicate::__convertStringsToObjects($vars);
			
				$this->charArray = false;
					
			}
			else{
				$this->charArray = true;
				
				for($index=0; $index < strlen($string); $index++){
					
					array_push($this->listValues, $string[$index]);
				
				}
				
			}
		
		}
		else{
			
			$this->charArray = true;
			
			for($index=0; $index < strlen($string); $index++){
				
				array_push($this->listValues, $string[$index]);
			
			}
						
		}
						
	}
	
	function type(){

		return 'list';
		
	}
	
	function listToString(){

		//Starts with a [
		$resultString ='';
		$resultString .= '[';
			
		for($index=0; $index < sizeof($this->listValues); $index++){
		
			$resultString .= $this->listValues[$index]->toString();
						
			if( $index < (sizeof($this->listValues)-1)){
			
				$resultString .= ',';
				
			}
			
		}
		//Ends with a [
		$resultString .= ']';
		
		
		return $resultString;
	
		
		
	}
	
	
	function charListToString(){

		$resultString='';
		
		$resultString .= '"';
			
		for($index=0; $index < sizeof($this->listValues); $index++){
		
			$resultString .= $this->listValues[$index];
					
		}
		
		$resultString .= '"';
			
		return $resultString;
	
	}
	
	
	
	function toString(){

		$resultString='';
		
		if($this->charArray){//List is a char array
			
			$resultString = $this->charListToString();
			
		}
		else{
		
			$resultString = $this->listToString();
			
		}
		
		return $resultString;
		
	}

}
?>