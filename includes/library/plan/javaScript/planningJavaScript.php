<?


/* class planningJavaScript {{{ */
/**
 * Deals with processing action packets building javaScript plans
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.javaScript
 */
/* }}} */

class planningJavaScript{

function actOnJavascriptPlanActions($actionPackets){
	
	$plansConvergence = false;
	
	$constraintsArray = array();

	//Setup the javascript collections
	for($index=0; $index < sizeof($actionPackets); $index++){

		$constraintsArray[$index] = new javaScriptCollection();
		
	}
	
	while(! $plansConvergence){//Plans have have converged to a single plan
		
		$actionArray = array();
		$packetCollection = array();
				
		for($index=0; $index < sizeof($actionPackets); $index++){
			
			$actionNode = $actionPackets[$index]->getAction();
			$data = $actionNode->getData();
			$actionPredicate = node::getNodeData($data);
				
			//Find the values for this conditional action
			$predicateValues = $actionPredicate->getPredicateValues();
			
			//Create a new javascript constraint
			$javaScriptConstraint = new javaScriptConstraint($predicateValues[1]->toString(),$predicateValues[2]->toString(),$predicateValues );
			
			//Add this constraint to the associated collection
			$constraintsArray[$index]->addConstraint($javaScriptConstraint);

			//Find the next action for this action packet
			$nextActionPackets = planAction::fetchNextAction($actionPackets[$index]->getPlans());

			$nextAction = $nextActionPackets[1];
			$actionArray[$index] = $nextAction[0]->toString();
			
			$packetCollection = array_merge($packetCollection, $nextActionPackets[0]);
				
		}
		
		$plansConvergence = arrays::allEqual($actionArray);

		if(!$plansConvergence){
			
			$actionPackets = $packetCollection;
						
		}		
			
	}
	//Plans must have convereged so it does not matter which one we return!
	return array('actionPackets'=>$actionPackets[0] ,'constraints'=>$constraintsArray);
	
	//return $actionPackets[0];
	
}

}

?>