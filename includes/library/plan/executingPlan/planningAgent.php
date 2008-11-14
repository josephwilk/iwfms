<?

/* class planningAgent {{{ */
/**
 * Functions for dealing with the execution of plans
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.executingPlan
 */
/* }}} */


class planningAgent{

	function updatePlans($plans){
		
		graphPlanDatabaseAccess::updatePlanGraphList($_POST['workflowID'],$plans);
		
	}
	
	function see( $messages, $conditionID){
	
		return $messages[$conditionID];
			
	}

	
	function doit($planList, $conditionMode,$conditionValue, $messages, $message, $conditionID){
		
		$match = false;
		
		if($conditionMode == 'presence' ){//Check the edge Progression condition
		
				if ($message != '' || !isset($message)){
			
					$match = true;
					systemMessages::message($conditionID . ' was filled in !');
					
				}
				else{
				
					systemMessages::message($conditionID . ' was not filled in! ');
					
				
				}
		}
		elseif ($conditionMode == 'match'){
						
			/*if(!isset($message) | $message == ''){//Equivalent to False
					
				$message = 'false';
					
					
			}*/
				
			if ($message == $conditionValue){//Condition met
			
				$match = true;
				systemMessages::message($conditionID . ' matched with ' . $conditionValue);
				
				
			}
			else{

				systemMessages::message($conditionID . ' not matched with ' . $conditionValue);
									
			}
		}
		elseif ($conditionMode == 'relativeExpression'){
	
			switch($conditionValue){
				
				case 'number' :
					$reg="/[\d]+/";
					break;	
				
				
			}
			
			if(preg_match($reg, $message)){
			
				$match = true;
				systemMessages::message($conditionID . ' matched with relative expression' . $conditionValue);
				
			}
			else{

				systemMessages::message($conditionID . ' not matched with relative expression: ' . $conditionValue);
				
			}
				
		}
		else{
			
			errors::errorMessage("unrecognised Mode '.$conditionMode.' set in the plan!");
			
		}
		
		return $match;
			
	}
	
	

	function action($planList, $messages){
	
		$IDPosition = 0;
		$modePosition = 1;
		$valuePosition = 2;
			
		$match = false;
		
		$index =-1;
		
		while( $index < sizeof($planList)-1 && (! $match) ){
				
			$index++;
			
			$actionNode = $planList[$index]->getAction();
			
			$actionNodeData = $actionNode->getData();
	
			$edgeProgression = $actionNodeData[0];
		
			$edgeActionValues = $edgeProgression->getPredicateValues();
	
			$condition = $edgeActionValues[sizeof($edgeActionValues)-1];
	
			$conditionValues = $condition->getPredicateValues();
			
			
			
			$conditionID = $conditionValues[$IDPosition]->toString();
			$conditionMode = $conditionValues[$modePosition]->toString();
			$conditionValue = $conditionValues[$valuePosition]->toString();
	
			//Examine the message
			$message = planningAgent::see($messages, $conditionID);
			
		$match = planningAgent::doit($planList[$index], $conditionMode,$conditionValue, $messages, $message, $conditionID);
		
	}
	return array('match'=>$match, 'actionPacket'=>$planList[$index]);
}

	
	
	
	function actionTest($planList, $messages, $conditionID, $conditionMode){
	
		$IDPosition = 0;
		$modePosition = 1;
		$valuePosition = 2;
			
		$match = false;
		
		$index=-1;
		
		
		while( $index < sizeof($planList)-1 && (! $match) ){
	
			$index++;
		
			$actionNode = $planList[$index]->getAction();
			
			$actionNodeData = $actionNode->getData();
	
			$edgeProgression = $actionNodeData[0];
		
			$edgeActionValues = $edgeProgression->getPredicateValues();
	
			//$condition = $edgeActionValues[sizeof($edgeActionValues)-1];
			//$conditionValues = $condition->getPredicateValues();
			
			$conditionValue =$edgeActionValues[$valuePosition]->toString();

			//Examine the message
			$message = planningAgent::see($messages, $conditionID);
			
			//Finding the matching action packet
						
			$match = planningAgent::doit($planList[$index], $conditionMode,$conditionValue, $messages, $message, $conditionID);	
				
						
		}
		
		if(!$match){
	
			errors::errorMessage("No progression was found!");
			
		}
		else{
		
			//Check the chosen action packet
			if( $planList[$index]->atGoal() ){//At goal node
		
				planArchieving::archive($_POST['workflowID']); 
			
				systemMessages::message("Goal Node reached!");
			}
			
			
		}
		
		return $planList[$index];
		
	}
	
}