<?


/* class typeRule {{{ */
/**
 * Represents a prolog Definite clause grammar rule
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package htmltyping
 */
/* }}} */

class typeRule{
	
	
	var $regularExpressionPredicate = "childrentyping";
	
	var $typename;
	var $ruleList = array(); // A list of clauses
	
	var $children;
	
	var $regularExpression;
	
	function typerule($typename=""){
		$this->typename = $typename;	
	}
	
	function setRegularExpression($regularExpression){
		
		$this->regularExpression = $regularExpression;
		
	}
	
	
	function addClause($clause){
		
		array_push($this->ruleList , $clause);
			
	}
	
	function setChildren($children){
		
		$this->children = $children;
	
	}
	
	function toString(){

		if($this->regularExpression){
		
			//Display regular expression predicate
			$predicateVars[0] = new prologAtom($this->typename);
			$predicateVars[1] = new prologString($this->regularExpression);
					
			$regPredicate = new prologPredicate($this->regularExpressionPredicate, $predicateVars );
			
			echo $regPredicate->toString();
			
			echo ".\n";
			
		}
						
		for($index=0; $index < sizeof($this->ruleList); $index++){
		
			$typeRule = $this->ruleList[$index];
			
			//Display rule
			echo $typeRule->toString();
											
		}		
				
	}
	
	
	function toArray(){

		$resultArray = array();
		$resultIndex=0;
			
		if($this->regularExpression){
		
			//Display regular expression predicate
			$predicateVars[0] = new prologAtom($this->typename);
						
			$predicateVars[1] = new prologList($this->regularExpression);
			
			$regPredicate = new prologPredicate($this->regularExpressionPredicate, $predicateVars );
				
			$resultArray[$resultIndex] = $regPredicate->toString() . ".\n";
			
			debug::message($resultArray[$resultIndex]);
			
			$resultIndex++;
			
					
		}

			
		for($index=0; $index < sizeof($this->ruleList); $index++){
			
			$typeRule = $this->ruleList[$index];

			
					
			//Display rule
			$resultArray[$resultIndex]= $typeRule->toString();
			
			
			
			$resultIndex++;
								
		}		
		
		return $resultArray;
				
	}
		
}

?>