<?

/* class actionPacket {{{ */
/**
 * This is used to represent an action and the plans that the action is 
 * active in. This shows paths to follow when reaching conditional actions
 * and linear paths with linear actions
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan
 */
/* }}} */

class actionPacket{
	
	var $action;
	var $planList = array();
	
	/**
	* @return actionPacket
	* @param String $action
	* @desc Constructor
	*/
	function actionPacket($action){

		$this->action = $action;
		
	}
	
	/**
	* @return void
	* @param GraphPlan $plan 
	* @desc Add a plan to the plans associated with this action packet
	*/
	function addPlan($plan){

		array_push($this->planList, $plan);
		
	}
	
	/**
	* @return void
	* @param GraphPlan $plan
	* @desc Merge the plan with the action packets current plan list
	*/
	function mergePlan($plan){

		$this->planList =array_merge($plan, $this->planList);
			
	}
	
	/**
	* @return Node
	* @desc Fetchs the action for this actionPacket
	*/
	function getAction(){
		
		return $this->action;	
		
	}
	
	/**
	* @return Array an array of graphPlans
	* @desc Fetchs the plans associated with this actionPacket
	*/
	function getPlans(){
		
		return $this->planList;	
		
	}
	
	/**
	* @return void
	* @desc Move one step forward in each of the plans assocaited with the actionPacket
	*/
	function progressPlans(){

		$planListSize = sizeof($this->planList);
		for($index=0; $index < $planListSize; $index++){

			$this->planList[$index]->progress();		
			
		}
		
	}
	
	
	/**
	* @return Boolean
	* @desc Determines whether the first plan is at the goal
	*/
	function atGoal(){

		//Since all plans associated with this action packet
		//have the same next node we only need to look at one of them
		
		if( $this->planList[0]->getCurrentNode() ){// There is a next node
		
				return false;
			
		}
		return true;
		
		
	}
	
	
	function checkForLoopReentry($entryTimepoint){
		
		$loopReEntryDetected= false;
		
		
		$planListSize = sizeof($this->planList);
		for($index=0; $index < $planListSize; $index++){
			
			$loopReEntryDetected = $this->planList[$index]->checkForLoopReentry($entryTimepoint);
			
		}	
		
		return $loopReEntryDetected;
		
	}
	
	/**
	* @return Boolean
	* @param String $entryTimepoint
	* @desc Checks to see if a timepoint has a loop
	*/
	function checkForLoop($entryTimepoint){
		
		$loopDetected= false;
		
		$planListSize = sizeof($this->planList);
		for($index=0; $index < $planListSize; $index++){
			
			$loopDetected = $this->planList[$index]->checkForLoop($entryTimepoint);
			
		}	
		
		return $loopDetected;
		
	}
	
	
	
	/**
	* @return Array
	* @param Array[ActionPackets] $actionPackets
	* @desc Checks if there is a loop in the action packets
	*/
	function checkActionPacketsForLoop($actionPackets){

		$loop = false;
		$formName ='';
		
		
		$actionPacketsSize = sizeof($actionPackets);
		for($index=0;$index < $actionPacketsSize; $index++){
	
			$currentAction = $actionPackets[$index]->getAction();
	    	$data = $currentAction->getData();
				
			$entryTimepoint = $currentAction->getName();
			$vars = $data[0]->getPredicateValues();
			$formName =  $vars[0]->toString();
		
				
			$loop = $actionPackets[$index]->checkForLoop($entryTimepoint);
				
		}
	
		return array('formName'=>$formName, 'loop'=>$loop);
		
	}
	
	function processLoop($planGraphList, $workflowID){

		//Find the next Actions
    	$possibleActions = planComparison::compareActions($planGraphList, false);
    
	    $loopResult = actionPacket::checkActionPacketsForLoop($possibleActions);
	    
	    if ( $loopResult['loop'] ){//Check to see if we are looping
	
	    	systemMessages::message("Workflow is Looping!");
	    
	    	$planGraphList = graphPlanDatabaseAccess::getPlanState($workflowID, $loopResult['formName']);
	    	
	    	graphPlanDatabaseAccess::updatePlanGraphList($workflowID, $planGraphList);
	    	
	    	$possibleActions = planComparison::compareActions($planGraphList, false);
	    	
	    }
	    
	    return $possibleActions;
		
	}
	
	
	
}
?>