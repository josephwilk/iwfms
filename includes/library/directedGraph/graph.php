<?
/* class graph {{{ */
/**
 * Directed graph used to represent event calculus plans
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package directedGraph
 */
/* }}} */


class graph{

	var $nodes = array();
	var $edges = array();

	/**
	* @return Array of Edges
	* @desc Enter description here...
	*/
	function getEdges(){

		return $this->edges;
		
	}
	
	
	/**
	* @return String
	* @desc Convert Edges to SVG format
	*/
	function toSVGTime(){
		
		$stringResult = "";
		
		for($index=0;$index<sizeof($this->edges); $index++){
		
				 $stringResult .= $this->edges[$index]->toSVGTime();
		}
		
	 	return $stringResult;
						
	}
	
	
	
	/**
	* @return String
	* @desc Convert graph to SVG format
	*/
	function toSVG(){

		$stringResult = "";
		
		for($index=0;$index<sizeof($this->edges); $index++){
		
				$edges = $this->edges[$index]->toSVG();
									
				$node1 = $this->findNode($edges[0]);
				
				if($node1!=''){
				
					$stringResult .= $node1->toString();
					
					$stringResult .= '->';
					
					if($edges[1] != 't'){
					
						$node2 = $this->findNode($edges[1]);
						
						if($node2){
							$stringResult .= $node2->toString();
						}
						else{
							$stringResult .= 'emptyNode';
								
						}
					
					}
					else{
						
						$stringResult .= "goalNode";
						
					}
				
										
					$stringResult .= ";\n";
					
				}
		}

		//Required for compatilbitly of SVG generator
		return preg_replace("/\(|,|\)|\]|\[|_|=/", "_", $stringResult);
		
	}
	
	
	/**
	* @return Node - next timepoint
	* @param $name String
	* @desc Finds the connections between the given timepoint	
 	*/
	function findConnections($name){
				
		$nodeList = array();
		
		for($index=0;$index<sizeof($this->edges); $index++){

			if( $result = $this->edges[$index]->match($name)){
				
				array_push($nodeList, $result);
				
			}	
		}
		
		if( sizeof($nodeList) == 1){ //Only one choice
				
			return $nodeList[0];
				
		}elseif( sizeof($nodeList) > 1 ){
				
				errors::errorMessage('FATAL ERROR PLAN IS NOT TOTALLY ORDERED!!!');	
				return false;
		
		}
		
		//Failed to match
		return false;
		
	}
	
	/**
	* @return Array of Edges
	* @param String $name
	* @param Array $history
	* @desc Find all orderings linking into the passed node
	*/
	function findBackwardsConnections($name, $history){
		
		$nodeList = array();
		
		$edgesSize = sizeof($this->edges);
		for($index=0; $index < $edgesSize; $index++){

			$result = $this->edges[$index]->matchReverse($name);
						
			if( $result && !arrays::member($result, $history) ){
								
				array_push($nodeList, $result);
				
			}	
		}
		
		return $nodeList;
			
	}
	
	
	/**
	* @return unknown
	* @param String $name
	* @desc Locate a node based on name
	*/
	function findNode($name){
		
		for($index=0;$index<sizeof($this->nodes); $index++){
			if( $this->nodes[$index]->name == $name){
				return $this->nodes[$index];	
			}	
		}
		return false;
	}
	
	/**
	* @return void
	* @param Array $edgeList
	* @desc Sets the edges for this graph
	*/
	function createEdges($edgeList){
		
		$this->edges = $edgeList;
		
	}
	
	/**
	* @return void
	* @param Edge $edge
	* @desc Add a single edge to this graph
	*/
	function addEdge($edge){

		array_push($this->edges, $edge);
		
	}
	
	/**
	* @return void
	* @param Node $node
	* @desc Add a node to this graph
	*/
	function addNode($node){

		array_push($this->nodes, $node);
		
	}
	
	/**
	* @return Boolean
	* @param String $entryTimepoint
	* @param Array $history
	* @desc Detects if this timepoint is a loop re-entry point
	*/
	function checkForLoopReentry($entryTimepoint, $history){
		
		if(sizeof($this->findBackwardsConnections($entryTimepoint, $history) )){
			
			return true;	
			
		}
		
		return false;
	
	}
	
		
}
?>