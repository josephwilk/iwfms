<?

/* class edge {{{ */
/**
 * collection of temporal orderings *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package directedGraph
 */
/* }}} */



class edge{
	
	var $point1;
	var $point2;
	
	/**
	* @return edge
	* @param String $point1
	* @param String $point2
	* @desc Constructor for a new edge
	*/
	function edge($point1,$point2){

		$this->point1 = $point1;
		$this->point2 = $point2;
		
	}
	
	/**
	* @return Array
	* @desc returns the two timepoints in an array
	*/
	function toSVG(){
		
		return array(0=>$this->point1, 1=>$this->point2);
		
	}
	
	/**
	* @return String
	* @desc Returns the timepoints in DOT specification format
	*/
	function toSVGTime(){
		
		return "$this->point1 -> $this->point2;\n";	
		
	}
	
	
	/**
	* @return String
	* @param String $name
	* @desc Checks if the destination node for this edge matches name
	*/
	function matchReverse($name){

		if($name == $this->point2){
		
			return $this->point1;
				
		}
		return false;
		
	}
	
	
	
	/**
	* @return String
	* @param String $name
	* @desc Checks if a timepoint matches with this source edge
	*/
	function match($name){

		if($name == $this->point1){
		
			return $this->point2;
				
		}
		return false;
		
	}
	
}

?>
