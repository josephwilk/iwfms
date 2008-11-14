<?
/* class prologPlanCollection {{{ */
/**
 * The prologPlanCollection class represents a collection of action predicates. 
 * It provides functions to breakup a string list of plans and orderings 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package prolog.abstractStructures
 */
/* }}} */


class prologPlanCollection extends prologConstructCollection {

	
	/**
	* @return prologPlanCollection
	* @param $planList unknown
	* @desc Constructor	
 */
	function prologPlanCollection($planList){
		
		$this->constructs = $planList;	
		
	}
	
	/**
	* @return PrologPredicate
	* @desc Returns the start node
 */
	function startNode(){
		return $this->constructs[0];
	}
	
	
	
	/**
	* @return Array of actions
	* @param $timepoint String
	* @desc Fetchs all actions that occur at a specific timepoint
 */
	function getMatchingAction($timepoint){
		
		$actionArray = array();
		
		for($index=0;$index< sizeof($this->constructs); $index++){
						
			$object =  $this->constructs[$index]->match($timepoint);	
			
			if($object){	
			
				//print_r($object);
			
				array_push($actionArray ,$object);
			
			}
			
		}
		return $actionArray;
		
	}
	
	
		
	/**
	* @return String
	* @param $plans String
	* @desc Strips the first and last bracket of the plans string to simply regular expression processing
 */
	function preparePlans($plans){
	//pre: plans = [ [ [Plan], [Order] ], [ [Plan] , [Order] ], ... ]
	//post: r =  [ [Plan], [Order] ], [ [Plan] , [Order] ], .. 
		
		$plans = substr($plans, 1, strlen($plans)-2); 
	
		 //This is replacing any \n in the string
		 $plans = str_replace("
	", "", $plans);
		 $plans = str_replace(" ", "", $plans);
	
		 return $plans;	
		
	}
	
	 
	 /**
	 * @return Array(prologPlanCollection, prologOrderingCollection)
	 * @param $plans String
	 * @desc Converts a string with multplie plans into arrays, each containing
	 * a prologPlanCollection and prologOrderingCollection
	 */
	 function organisePlans($plans){
	//pre:  [ [Plan], [Order] ], [ [Plan] , [Order] ], [ [Plan] , [Order] ]
	//post: r = array grouping plans and orderings

		//Convert empty lists into empty strings to avoid conflicts with breaking
		//Orderings and plans apart
		$plans = preg_replace('/,\[\],/', ',"",', $plans);
			
		preg_match_all('/\[\[([\W|\w]*?)\]\]/', $plans, $matches);

		for($index=0; $index < sizeof($matches[1]); $index++){
			
			//Break the plan and orderings apart
			$planAndOrdering = preg_split('/\],\[/', $matches[1][$index]);
			
			$planPackage[$index]['plan'] = $planAndOrdering[0];
			$planPackage[$index]['ordering'] = $planAndOrdering[1];
			
			//echo "<b>plan</b>:<br>" . $planPackage[$index]['plan'] . '<br><br>';
					
			$beforePredicate = new prologBeforePredicate();
			$happensPredicate = new prologHappenPredicate();
			
			//Uses prolog predicate to parse plan string into Happens predicates
			$planPackage[$index]['plan'] =  new prologPlanCollection( prologPredicate::seperatePredicateList($planAndOrdering[0], 'happens', $happensPredicate) );
	
			//Uses prolog predicate to parse ordering string into Happens predicates
			$planPackage[$index]['ordering'] = new prologOrderingCollection( prologPredicate::seperatePredicateList($planAndOrdering[1], 'before',$beforePredicate) );
					
			//echo "<b>ordering</b>:<br>" . $planPackage[$index]['ordering'] . '<br><br>';
			
		}
		return $planPackage;
	
	}
}
?>