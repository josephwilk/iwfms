<?

/* class planAction {{{ */
/**
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.executingPlan
 */
/* }}} */


class planAction{

/**
 * @return Array(Array(ActionPlans), Array(Actions), String)
 * @param $planList Array of plangraphs
 * @param $action String
 * @desc Finds actions upto and including $action
 */
function findRequiredActions($planList,$action){
	
	$possibleActions = '';
	$actionCollection = array();
	
	$submitActionEncountered= false;
	$conditionalEncountered = false;
	$goalStateReached = false;
	$matchingAction = false;
	
	$matchReason = 'match';
	$conditionalReason = 'conditional';
	$goalReason = 'goal';
	
	
	while( !$conditionalEncountered && 
		   !$goalStateReached &&
		   !$matchingAction){
		   	
		//We have not reached the goal state
		if ($possibleActions = planComparison::compareActions($planList, true) ){

			//We have not reached a decision point
			if (! planComparison::conditionalAction($possibleActions)){

				//This is only one action
				$currentAction = $possibleActions[0]->getAction();
			
				$nodeData = $currentAction->getData();
				
				if( $action == $nodeData[0]->getPredicateName() ){
					
					$returnReason = $matchReason;
					$matchingAction = true;
					
				}
			
				array_push($actionCollection, $nodeData[0]);
				$planList = $possibleActions[0]->getPlans();
			
			}
			else{// Conditional action encountered
		
				systemMessages::message("Plan decision point encountered");
				
				//Check the first action
				$currentAction = $possibleActions[0]->getAction();
			
				
				$nodeData = $currentAction->getData();
				array_push($actionCollection, $nodeData[0]);
				
				debug::message("Conditional predicate name:".$nodeData[0]->getPredicateName());
			
					
				//Matching predicate over conditional
				if( $action == $nodeData[0]->getPredicateName() ){
					
					$returnReason = $matchReason;
					$matchingAction = true;
					
				}
				else{
				
					$returnReason = $conditionalReason;
					$conditionalEncountered = true;	
					
				}
			}
		}
		else{// Goal node reached
		
			systemMessages::message("Goal Node reached");
			
			$returnReason = $goalReason;
			$goalStateReached=true;	
			
		}
	}
	
	debug::message($returnReason);
	
	return array('actionPackets'=>$possibleActions, 'actionNames'=> $actionCollection, 'reason'=>$returnReason);
	
}







function fetchNextAction($planList){
		
	
	//There is a bug in PHP
	//When trying to process very large objects it side effects the values!
	//To overcome this we must enforce a copy is made and then use this instead!
	
	$localPlanList = array();

	
	$planListSize = sizeof($planList);
	for($index=0;$index<$planListSize;$index++){
		
		$localPlanList[$index] = new graphPlan();
		$localPlanList[$index] = $planList[$index];
		
	}
	
	
	$possibleActions = array();
	$actionCollection = array();
		
	//We have not reached the goal state
	if ($possibleActions = planComparison::compareActions($localPlanList, false) ){

		//We have not reached a decision point
		if (! planComparison::conditionalAction($possibleActions)){

				//This is only one action
				$currentAction = $possibleActions[0]->getAction();
			
				$nodeData = $currentAction->getData();
				
				array_push($actionCollection, $nodeData[0]);
										
			}
			else{// Conditional action encountered
		
				systemMessages::message("Plan decision point encountered");
				
				//Only consider the first packet
				$currentAction = $possibleActions[0]->getAction();
			
				$nodeData = $currentAction->getData();
				
				array_push($actionCollection, $nodeData[0]);
					
			}
	}
	else{// Goal node reached
		
		systemMessages::message("GoalNode!");
	
			
	}
		
	return array($possibleActions, $actionCollection);
	
}


function conditionBehaviour($progressResult){
	
	$actionList = $progressResult['actionNames'];
	$action = $actionList[sizeof($actionList)-1];
	$predicateName =  $action->getPredicateName();
	
	switch($predicateName){

		case 'entry': //Javascript conditional

			debug::message('JavaScript Plan Actions');
			$resultArray = planningJavaScript::actOnJavascriptPlanActions($progressResult['actionPackets']);
			
			$actionPackets = $resultArray['actionPackets'];
			
			break;
		
		case 'formEntry': //Role based conditional
		
			debug::message('Role based decision Actions');
			
			//Select the plans that follow the role of the users accessing the form
			
			if(!isset($_GET['group'])){//This test is a serverside conditional
						
				$selectGraphs = planningAgent::actionTest($progressResult['actionPackets'], $_POST, 'group', 'match' );

			}
			else{// This test is a clientside conditional

				$selectGraphs = planningAgent::actionTest($progressResult['actionPackets'], $_GET, 'group', 'match' );
				
			}
				
				
			$actionPackets = $selectGraphs;
						
			//$progressResult = planAction::findRequiredActions($selectGraphs->getPlans(),"formSubmission");
			
			break;
	}

	if(isset($resultArray)){
	
		return array('actionList'=> $actionList, 'plans'=>$actionPackets, 'javaConstraints'=>$resultArray['constraints']);
	
	}

	return array('actionList'=> $actionList, 'plans'=>$actionPackets, 'javaConstraints'=>array());
	
}
	
	function actOnPlan( $planGraphList, $action ){
	
		$match = false;
		$result = array();
		
		$actionList = array();
		while(!$match){
					
			//Find me all actions up untill and including submission
			$plannerProgress = planAction::findRequiredActions($planGraphList,$action);
			
			//Reason for the planner stopping
			switch ($plannerProgress['reason']){
			
				case 'conditional':
			
					$result = planAction::conditionBehaviour($plannerProgress);
					$actionList = $result['actionList'];
					
					$planGraphList = $result['plans']->getPlans();
					$plannerProgress['actionPackets'] = $result['plans'];
					
					break;	
					
				case 'match':
		
					$actionList = array_merge($actionList, $plannerProgress['actionNames']);
					$match = true;
										
					break;
			
				case 'goal':
				
					$match = true;
					break;
			}
		
		}

		if(isset($result['javaConstraints'])){
				
			return array('actionPackets'=>$plannerProgress['actionPackets'], 'actionList'=>$actionList, 'javaConstraints'=>$result['javaConstraints']  );
			
		}
		else{

			return array('actionPackets'=>$plannerProgress['actionPackets'], 'actionList'=>$actionList, 'javaConstraints'=>array()  );
			
		}
	}
}
?>