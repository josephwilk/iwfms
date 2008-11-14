<?

/* class prologHappenPredicate {{{ */
/**
 * represents the happens predicate of the event calculus
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package prolog.abstractDataStructures
 */
/* }}} */

class prologHappenPredicate extends prologPredicate {
		
	
	function match($timepoint){
		
		if($this->getTimepoint() == $timepoint){
		
			return 	$this->getAction();
			
		}
		
	}
	
	
	//Currently assumes that actions only occur at specific timepoints
	function getTimepoint(){
		
		return $this->predicateValues[1]->toString();
		
	}
	
	function getAction(){
		
		return $this->predicateValues[0];
		
	}
	
	
}


?>