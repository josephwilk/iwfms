<?

/* class prologConversion {{{ */
/**
 * Functions for converting to prolog formating
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package prolog
 */
/* }}} */

class prologConversion{
	
	//Convert an array into a prolog list [x,y,z,...]
	function arrayToPrologList($array){
				
		$arrayString = "[";
		
		for($index=0; $index < sizeof($array); $index++){
	
			$arrayString .= $array[$index]	;
			
			if( $index != sizeof($array)-1){ //Miss out last comma
				
				$arrayString .= ",";
				
			}
		
		}
		
		$arrayString .= "]";

		return $arrayString;
		
	}
		
}


?>