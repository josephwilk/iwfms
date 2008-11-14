<?

class typeRule{
	
	var $typename;
	var $clauses = array(); // A list of clauses
	
	var $children;
	
	var $regularExpression;
	
	function typerule($typename=""){
		$this->typename = $typename;	
	}
	
	function setRegularExpression($regularExpression){
		
		$this->regularExpression = $regularExpression;
		
	}
	
	
	function addClause($clause){
		
		array_push($this->clauses , $clause);
			
	}
	
	function setChildren($children){
		
		$this->children = $children;
	
	}
	
	function output(){
				
		asdasdsadfsdf
		$prologRegularExpression = new prologString($this->regularExpression);
		$regPredicate = new prologPredicate('childrenTyping', $prologRegularExpression );
		
				
		echo $regPredicate->toString();
		
			
		for($index=0; $index < sizeof($this->clauses); $index++){
		
			$clause = $this->clauses[$index];
			
			echo ($this->typename);
			echo $clause->outputClause();
			
			echo $clause->outputPreConditions($this->typename);

			echo $clause->xmlImpliedType;
					
			echo "\n";
											
		}		
				
	}
	
}

?>