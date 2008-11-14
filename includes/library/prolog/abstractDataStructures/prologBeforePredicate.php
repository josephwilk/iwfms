<?

/* class prologBeforePredicate {{{ */
/**
 * 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package prolog.abstractDataStructures
 */
/* }}} */

class prologBeforePredicate extends prologPredicate {


	function getTimePoints(){
		
		return $this->predicateValues[0]->toString();	
		
	}
	
	
	function match($timepoint){
		
		$timepointPackage = $this->getTimepoint();
		
		if( $timepointPackage[0] == $timepoint){
		
			return 	array(1=>$timepointPackage[1]);
			
		}
		elseif( $timepointPackage[1] == $timepoint ){
			
			return 	array(0=>$timepointPackage[0]);
			
		}
		
		return false;
		
		
	}
	
	function getTimepoint(){
		
		$timePointPackage[0] = $this->predicateValues[0]->toString();
		$timePointPackage[1] = $this->predicateValues[1]->toString();
		
		return $timePointPackage;
		
	}
	
	
	
	
}

?>
