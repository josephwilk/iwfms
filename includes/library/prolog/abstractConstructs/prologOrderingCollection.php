<?

/* class prologOrderingCollection {{{ */
/**
 * The prologOrderingCollection class represents a collection of prolog 
 * ordering constructs. 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 
 * @package prolog.abstractStructures
 */
/* }}} */

class prologOrderingCollection extends prologConstructCollection{
	
	
	/**
	* @return prologOrderingCollection
	* @param $orderings Array of before predicates
	* @desc Constructor
 	*/
	function prologOrderingCollection($orderings){
		
		$this->constructs = $orderings;
		
	}
	
	/**
	* @return array - an array of unique timepoints
	* @desc Locate the timepoints of all the before predicates	
    */
	function findallTimepoints(){

		$timepoints = array();

		for($index=0;$index<sizeof($this->constructs); $index++){
		
			//Do not add the timepoint if it is already in the list
			if(! arrays::member($this->constructs[$index]->getTimePoints(), $timepoints) ){
			
				array_push( $timepoints, $this->constructs[$index]->getTimePoints() );
			
			}
		}
				
		return $timepoints;		
	}
	
	
	/**
	* @return array - an array of edges
	* @desc Locate all the edges	
    */
	function findallEdges(){
		
		$results = array();
		
		//Find all timepoints
		$nodeArray = $this->findallTimepoints();
		
		//For each timepoint find all the links attached to it
		for($index=0; $index < sizeof($nodeArray); $index++){
		
			$matches = array();
			
			$matches = $this->findallLinks($nodeArray[$index]);
				
			$results = array_merge($matches, $results);
		}	
		
		$results = $this->removeDuplicates($results);
		
		return $results;		
	}
		
	/**
	* @return Array of edge objects
	* @param $timepoint String
	* @desc Finds the timepoint that corresponds to the argument timepoint	
 	*/
	function findallLinks($timepoint){
		
		$timepoints = array();
		
		for($index=0;$index<sizeof($this->constructs); $index++){
		
			$newtimepoint = $this->constructs[$index]->match($timepoint);
			
			if( $newtimepoint  ){// A timepoint was found
			
				if(isset($newtimepoint[0])){ //This is the sart of an edge
				
					array_push( $timepoints, new edge($newtimepoint[0], $timepoint));
				}
				else{ // This is the end of an edge
					
					array_push( $timepoints, new edge($timepoint, $newtimepoint[1]));
				}
				
				
			
			}
		}
		
		return $timepoints;
		
	}
	
	
	/**
	* @return Array
	* @param $array Array
	* @desc Removes duplicate edges
 	*/
	function removeDuplicates($array){
		
		$resultArray = array();
		
		for($index=0; $index < sizeof($array); $index++){
		
			if(! $this->alreadyIn($resultArray, $array[$index])){
			
				array_push($resultArray, $array[$index]);		
					
			}	
			
		}
		
		return $resultArray;
				
	}
	
	
	/**
	* @return Boolean
	* @param $array Array
	* @param $edge Edge Object
	* @desc Indicates if the edge is in the argument array	
 	*/
	function alreadyIn($array, $edge){
		
		for($index=0; $index < sizeof($array); $index++){
		
			if($this->compare($array[$index], $edge)){
			
				return true;	
				
			}	
			
		}
		return false;
			
	}
	
	
	
	/**
	* @return Boolean
	* @param $edge1 Edge object
	* @param $edge2 Edge object
	* @desc Compares whether two edges are identical	
 	*/
	function compare($edge1,$edge2){
		
		return ( $edge1->point1 == $edge2->point1 &&
				 $edge1->point2 == $edge2->point2
				);
			 
		
	}
	
}