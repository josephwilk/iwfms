<?php
/* class graphPlan {{{ */
/**
 * Represents a plan with extra information required to guide the planning
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan
 */
/* }}} */



class graphPlan{

	var $planGraph;
	var $startNode;
	
	var $currentPosition;
	
	var $history = array();
	
	
	function addToHistory($timepoint){
		
		array_push($this->history, $timepoint);
		
	}
	
	
	/**
	* @return void
	* @param $timepoint string
	* @desc Set the start point for the graph	
 	*/
	function setStartNode($timepoint){
		
		$this->startNode = $timepoint;
		$this->currentPosition = $timepoint;
		
	}

	
	/**
	* @return String
	* @desc Convert the plan into a SVG formated String
	*/
	function toSVG(){
		
		return $this->planGraph->toSVG();	
		
	}
	
	/**
	* @return String
	* @desc Convert the plans orderings into a SVG formated String
	*/
	function toSVGTime(){
		
		return $this->planGraph->toSVGTime();	
		
	}
	
	
	/**
	* @return void
	* @desc Move one step forward in the plan
	*/
	function progress(){
		
		//Not at the goal NODE!
		if($this->currentPosition != 't'){
		
			$this->addToHistory($this->currentPosition);
			
			$newoptions = $this->planGraph->findConnections($this->currentPosition);

			debug::message('<br>AT('.$this->currentPosition . ')-->');
			debug::message('(   '.$newoptions . '   )<br>') ;
		
					
			$this->currentPosition = $newoptions;
		}
					
	}
	
	
	function progressWithoutHistory(){
		
		//Not at the goal NODE!
		if($this->currentPosition != 't'){
		
			$newoptions = $this->planGraph->findConnections($this->currentPosition);

			debug::message('<br>AT('.$this->currentPosition . ')-->');
			debug::message('(   '.$newoptions . '   )<br>') ;
		
			$this->currentPosition = $newoptions;
		}
					
	}
	
	
	
	
	
	
	
	
	
	/**
	* @return String
	* @desc Returns the current node for this plan
	*/
	function getCurrentNode(){

		//Not at the goal node
		if($this->currentPosition != 't'){
		
			return $this->planGraph->findNode($this->currentPosition);
		
		}
		
		return false;
		
	}
	
	function getCurrentNodeSVG(){

		//Not at the goal node
		if($this->currentPosition != 't'){
		
			$node= $this->planGraph->findNode($this->currentPosition);
			$stringNode = preg_replace("/\(|,|\)|\]|\[|_|=/", "LL", $node->toString());
			
			$stringNode = preg_replace("/'/","LL",$stringNode);
			$stringNode = preg_replace("/[\d]*/","",$stringNode);
			$stringNode = preg_replace("/[LL]+/","_",$stringNode);

			return $stringNode;
		
		}
		
		return false;
		
	}
	
	function getCurrentTimepointSVG(){

		return $this->currentPosition;
		
	}
	
	
	/**
	* @return graphPlan
	* @desc Constructor
	*/
	function graphPlan(){
		$this->planGraph = new graph();
	}

	/**
	* @return void
	* @param prologOrderingCollection $orderingCollection
	* @desc Converts prologOrdering predicates to edges in the graph
	*/
	function createEdges($orderingCollection){
		$this->planGraph->createEdges($orderingCollection);
	}
		
	/**
	* @return void
	* @param unknown $nodes
	* @param prologPlanCollection $planCollection
	* @desc 
	*/
	function populateNodes($nodes, $planCollection){

		for($index=0;$index<sizeof($nodes);$index++){
			
			$this->planGraph->addNode( new node($nodes[$index], $planCollection->getMatchingAction($nodes[$index])) );		
		
		}
	}
	
	/**
	* @return String
	* @desc Converts Graph to a String
	*/
	function toString(){
		
		$resultString="";
		
		for($index=0;$index < sizeof($this->planPredicates); $index++){
		
			$resultString .= $this->planPredicates[$index]->toString();	
			
		}	
		
		return $resultString;
	}
	

	
	
	/**
	* @return String
	* @param prologHappensPredicate $actionPredicate
	* @desc Get the action name of the passed predicate
	*/
	function getAction($actionPredicate){
		
		$predicateValues = $actionPredicate->getPredicateValues();
		
		return $predicateValues[0]->getPredicateName();
		
		
	}
	
	/**
	* @return String
	* @param prologHappensPredicate $actionPredicate
	* @desc Get the timepoint assocaited with the action passed
	*/
	function getTimePoint($actionPredicate){
		$predicateValues = $actionPredicate->getPredicateValues();
		return $predicateValues[2]->toString();
	}
	
	/**
	* @return graphPlan
	* @param $orderingCollection OrderingCollection
	* @param $planCollection PlanCollection
	* @desc Creates a graphplan from the orderings and plan actions
 	*/
	function convertToGraphPlan($orderingCollection,$planCollection){
	
			$planGraph = new graphPlan();
			
			//The start node will always be the first node
			//Otherwise the plans would be undeterministic
			$startnode = $planCollection->startNode();
		
			//There will be a node for every timepoint
			$nodeList = $orderingCollection->findallTimepoints();
		
			//Find all edges
			$edgeList = $orderingCollection->findallEdges();
	
			//Create Nodes
			$planGraph->populateNodes($nodeList, $planCollection);
			
			//Create Edges
			$planGraph->createEdges($edgeList);
		
			//Set the start Node
			$planGraph->setStartNode($startnode->getTimePoint());
		
			return $planGraph;
			
	}
	
	/**
	* @return void
	* @desc
	*/
	function resolveLoops(){

		//Find all Nodes which move back to the goal
		
		$newoptions = $this->planGraph->findBackwardsConnections('t');

		for($index=0;$index < sizeof($newoptions); $index++){
		
			$graph = $this->planGraph;
			
			$node = $graph->findNode($newoptions[$index]);
			
			$nodeData = $node->getData();
						
			if( preg_match("/loop\(/", $node->toString()  ) ){
			
				errors::errorMessage("LOOP DETECTED!");
				$value=  $nodeData[0]->getPredicateValues();
				
				$loopPoint = $value[0]->getPredicateValues();
				
				echo $loopPoint[0]->toString();
				
			}
			
			
		}
		
		
	}
	
	
	function checkForLoopReentry($entryTimepoint){
		
		return $this->planGraph->checkForLoopReentry($entryTimepoint, $this->history);
		
	}
	
	function checkForLoop($entryTimepoint){
		
		return arrays::member($entryTimepoint, $this->history);
		
	}
	
	
	
}


?>