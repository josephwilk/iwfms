<?

/* class prologPredicate {{{ */
/**
 *  Representation of a prolog predicate and functions for conversions to and from predicates
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package prolog.dataStructures
 */
/* }}} */


class prologPredicate{
	
	var $predicateName;
	var $predicateValues;
		
	
	/**
	* @return prologPredicate
	* @desc Allows overloading of constructor
	*/
	function prologPredicate(){ 

		if(func_num_args()){//Only when arguments are passed are constructors used
		
			$meth="prologPredicate".func_num_args(); 
			$args = func_get_args();
			call_user_func_array(array(&$this, $meth), $args);
		
		}
		
	} 
		
	 
	
	/**
	* @return void
	* @param String $string
	* @desc prolog Predicate constructor created with a string
	*/
	function prologPredicate1($string){
	
		//Breakup predicate name and its values
		preg_match("/([^(,]+)(\([\w\W]*\))/", $string, $match);
		
		//Predicate Name
		$this->predicateName= $match[1];
		
		//Predicate Values
		$predicateString = $this->__cutOuterBrackets($match[2]);
		
		$values = $this->__separateStringPredicateVars($predicateString);
						
		$this->predicateValues = $this->__convertStringsToObjects($values);
	
	}
		
	
	
	/**
	* @return void
	* @param String $predicateName
	* @param Array $predicateValues
	* @desc prolog Predicate constructor
	*/
	function prologPredicate2($predicateName, $predicateValues){
			
		//Ensure predicates do not start with a capital letter
		$this->predicateName = string::lowFirstChar($predicateName);	
		
		$this->predicateValues = $predicateValues;
				
	}
	
	
	/**
	* @return Array
	* @desc Return predicate values
	*/
	function getPredicateValues(){

		return $this->predicateValues;
		
	}
	
	/**
	* @return string
	* @desc return predicates name
 */
	function getPredicateName(){

		return $this->predicateName;
		
	}
	
	/**
	* @return void
	* @param String $name
	* @desc Set this predicates name
	*/
	function setPredicateName($name){
		
		$this->predicateName = $name;
		
	}
	
	/**
	* @return void
	* @param Array $vals
	* @desc set this objects predicate values
	*/
	function setPredicateValues($vals){
		
		$this->predicateValues = $vals;
		
	}
	
	/**
	* @return String
	* @param String $stringValuesList
	* @desc retuns this predicate as a string predicatet
	*/
	function predicateToString($stringValuesList){
		return  $this->predicateName . '('. $stringValuesList . ")";
	}
	
	
	
	/**
	* @return String
	* @desc Generates a string representation of predicate with arguments as paramters
	*/
	function predicateValuesToString(){
		
		$variableStringList = "";
						
		for($index=0; $index < sizeof($this->predicateValues); $index++){
				
			$variableStringList .= $this->predicateValues[$index]->toString();
			
				
			if( $index < sizeof($this->predicateValues)-1 ){
			
				$variableStringList .= ',';
					
			}
		}
		
		return $variableStringList;
		
	}
	
	
	
	/**
	* @return string
	* @desc Generates a string with predicate containing values as attributes
 */
	function mapPredicateToString(){
				
		$predicateList = '';
		
		for($index=0; $index < sizeof($values); $index++){
						
			$predicateList .= $this->generatePredicateString($this->predicateName, $this->predicateValues[$index]);
			
		}
		
		return $predicateList;
	}

	
	
	/**
	* @return String
	* @desc Generates an array of predicates with values as atrributes
	*/
	function toString(){
	
		$variableStringList = $this->predicateValuesToString();
		
		return $this->predicateToString($variableStringList);		
						
	}
	
	
	
	//Parser which break up the values in a predicates values
	/**
	* @return unknown
	* @param unknown $predicateString
	* @desc Enter description here...
	*/
	function __separateStringPredicateVars($predicateString){
			
		//echo $predicateString;
		
		$insidebracket=0;
		$accum = array();
		$comma=0;
		
		//due to command line reading of prolog ,'', is removed leaving ,,
		$predicateString =  preg_replace("/,,/",",'',", $predicateString);		
						
		for($charIndex=0; $charIndex < strlen($predicateString); $charIndex++){
				
			$add = true;
			switch($predicateString[$charIndex]){
					
				case '(':
					$insidebracket++;
					break;
				
				case ')':
					$insidebracket--;
					break;
			
				case '[':
					$insidebracket++;
					break;
				
				case ']':
					$insidebracket--;
					break;
										
				case ',':
					if(!($insidebracket > 0)){
						$comma++;
						$add = false;
					}
			}
			
			
			if($add && $predicateString[$charIndex]!=' '){
				$accum[$comma] .= $predicateString[$charIndex];
			}
										
		}
				
		return $accum;	
		
	}
	
	/**
	* @return String
	* @param String $string
	* @desc Remove redundant first and last bracket
	*/
	function __cutOuterBrackets($string){
	
		return substr($string, 1, strlen($string)-2); 
				
	}
	
	
	/**
	* @return Boolean
	* @param String $string
	* @desc check if its a predicate.
	*/
	function __isPredicate($string){
			
		return preg_match("/^([^(,]+)(\([\w\W]*\))/", $string);	
		
	}
	
	
	//Convert Prolog strings into Prolog objects
	/**
	* @return unknown
	* @param unknown $predicateVars
	* @desc Enter description here...
	*/
	function __convertStringsToObjects($predicateVars){
			
		$predicateValObjects = array();
				
		for($indexVals=0;$indexVals<sizeof($predicateVars);$indexVals++){

			debug::message($predicateVars[$indexVals]);
				
			//The string represents a predicate
			if( prologPredicate::__isPredicate($predicateVars[$indexVals]) ){
			
				$predicateValObjects[$indexVals] = new prologPredicate($predicateVars[$indexVals]);	
								
			}
			elseif(preg_match("/\[[^\]]*\]/", $predicateVars[$indexVals])){ //This is a List
			
				$predicateValObjects[$indexVals] = new prologList($predicateVars[$indexVals]);
												
				//print_r($predicateValObjects[$indexVals]);
				
			}
			else{//This is a atom
				
				$predicateValObjects[$indexVals] = new prologAtom($predicateVars[$indexVals]);	
				
			}
		}	

		return $predicateValObjects;
			
	}
	
	/**
	* @return Array(PrologPredicate)
	* @param $predicateList String
	* @param $predicateName String
	* @param $predicateObject PrologPredicate
	* @desc Converts a prolog predicate string list into an array of each predicate object
    */
	
	function seperatePredicateList($predicateList, $predicateName, $predicateObject){
			
		$predicateListArray = array();
	
		$predicateListArray = explode(",$predicateName", $predicateList);
		
		//Strip the first reference to the predicateName
		$predicateListArray[0] = preg_replace("/$predicateName/","",$predicateListArray[0]);
				
		for($index=0; $index < sizeof($predicateListArray); $index++){
			
			//Remove any white space
			$predicateListArray[$index] = preg_replace("/\s/","h",$predicateListArray[$index]);
			
			//Remove redundant first and last bracket
			$predicateListArray[$index] = prologPredicate::__cutOuterBrackets($predicateListArray[$index]);
									
			//Find all variables of predicate
			$predicateVars = prologPredicate::__separateStringPredicateVars($predicateListArray[$index]);

			//Recursively convert them into relevant objects
			$predicateValObjects = prologPredicate::__convertStringsToObjects($predicateVars);

			if($predicateObject){
				
				//Create Base predicate
				
				$predicateObject->setPredicateName($predicateName);
				$predicateObject->setPredicateValues($predicateValObjects);
				
				$predicate = $predicateObject;
				
			}
			else{
			
				$predicate = new prologPredicate($predicateName,$predicateValObjects);
				
				
			}
			
			
			//echo $predicate->toString();
					
			$predicateListArray[$index] = $predicate;
				
		}
		
		return $predicateListArray;
		
	}
	
	
	/**
	* @return Array of predicate strings
	* @param $predicateArray array
	* @param $delimiter string
	* @desc returns an array of predicate strings with delimiter on the end
 */
	function convertArrayPredicatesToString($predicateArray,$delimiter){
		
		$result = array();
	
		for($index=0;$index<sizeof($predicateArray);$index++){

			array_push($result, $predicateArray[$index]->toString() . $delimiter);
		}
	
		return $result;	
		
		
	}
		
	function type(){
		
		return 'predicate';	
		
	}
	
}


?>