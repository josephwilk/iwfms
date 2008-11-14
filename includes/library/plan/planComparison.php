<?
/* class planComparison {{{ */
/**
 * functions for Comparing plans, fetching action packets and processing them
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package plan
 */
/* }}} */

class planComparison{


/**
 * @return boolean
 * @param $object1 prologPredicate
 * @param $object2 prologPredicate
 * @desc compares whether two predicates are equal
 */
function compare($object1, $object2){

	debug::message($object1->toString() ."==". $object2->toString() . '<br><br>');	
	
	return $object1->toString() == $object2->toString();	
}




/**
 * @return Array['array'] = actionPackets not matched and Array['actions'] = actionPackets that matched
 * @param $array array of ActionPackets 
 * @param $object Action Packet
 * @desc splits the actions packets into those that match the action and those that dont
 */
function getAllMatchingActions($actionPacketarray, $object){
		
	$actions = array();
	
	//Get the Node
	$currentNode = $object->getAction();
	
	//Get the data from the node
	$currentNodeData = $currentNode->getData();
	
	$index=0;
	while( $index < sizeof($actionPacketarray) ){
				
		//Get the Node
		$compareNode= $actionPacketarray[$index]->getAction();
		
		//Get the data from the node
		$compareNodeData = $compareNode->getData();
				
		//If we have a match we want to remove that item from the array
		if(planComparison::compare($compareNodeData[0], $currentNodeData[0])){	
			
			//Add the actionPacket to the result list
			array_push( $actions, $actionPacketarray[$index] ); 
			
			$actionPacketarray = arrays::array_chop($actionPacketarray,$index);
				
		}else{// No match!
		
			$index++;	
			
		}
	}

	//actionPackets not matched
	$result['array'] = $actionPacketarray;
	
	//actionPackets that matched	
	$result['actions'] = $actions;
	
	return $result;
	
}


/**
 * @return array of actionPackets
 * @param $planList Array of graphNodes
 * @desc Returns the next actions and the plans associated with them
 */
function findNextActions($planList, $updateHistory){

	$currentActions = array();
	
	$planListSize = sizeof($planList);
	for($index=0; $index < $planListSize; $index++){
		
		//At the goal state we will stop generating nextNodes
		
		if( $planList[$index]->getCurrentNode() ){
			
			$packet = new actionPacket( $planList[$index]->getCurrentNode() );
		
			if($updateHistory){
			
				//Note progression along the graph
				$planList[$index]->progress();
			
			}
			else{
			
				$planList[$index]->progressWithoutHistory();	
				
			}
			
			$packet->addPlan( $planList[$index] );
			
			array_push($currentActions, $packet);
					
		}
	}

	return $currentActions;
	
}


	/**
	* @return ActionPacket
	* @param $node1 List of Action Packets
	* @param $nodes Action Packets
	* @desc Take the graph plans from the actionpacket list and added them to the action Packet
 	*/
	function merge($actionPacketList, $actionPacket){

		$actionPacketListSize = sizeof($actionPacketList); 
		for($index=0; $index < $actionPacketListSize; $index++){
		
			$planArray = $actionPacketList[$index]->getPlans();
			
			$actionPacket->mergePlan($planArray);
						
		}	
		
		return $actionPacket;		

	}
	


/**
 * @return void
 * @param $currentActions array of actionPackets
 * @desc merges those actions packets that have the same action
 */
function composeActions($currentActions){

	$mergedActionPacketList = array();
	
	//Made a copy for breaking down
	$comparisonList = $currentActions;
	
	while(sizeof($comparisonList)!=0){ //We still have action packets to process
	
		//Save the comparison action packet
		$comparsionObject = $comparisonList[0];
		
		//Remove the action packet we are going to compare.
		$comparisonList = arrays::array_chop($comparisonList, 0);
		
		//Find matches of Action packet and list of action Packets
		$matches = planComparison::getAllMatchingActions($comparisonList, $comparsionObject );
		
		//Update the new array with those that did not match the action packet
		$comparisonList = $matches['array'];
			
		//Merge a list of actionPackets and a actionPacket
		$mergedActionPacket = planComparison::merge($matches['actions'],$comparsionObject); 
		
		//Collect result
		array_push($mergedActionPacketList, $mergedActionPacket);
				
		
	}
	
	return $mergedActionPacketList;
}



/**
 * @return void
 * @param $planList Array of planCollections
 * @desc compares Actions
 */
function compareActions($planList, $updateHistory){
	
	//Find a list of Action Packets
	$currentActions = planComparison::findNextActions($planList,$updateHistory);
	
	// [ACTION, Plan-i] , [ACTION, Plan-i+1]
		
	// [ACTION-Plan-i,Plan-i+1]
	
	//Merge relevant Action Packets
	$mergedActionPackets = planComparison::composeActions($currentActions);
	
	return $mergedActionPackets;
}

/**
 * @return boolean
 * @param $actionPacketList Array of action packets
 * @desc if there are more than one action packets there are more than
 * One choice for what to do next.
 */
function conditionalAction($actionPacketList){
	
	if(sizeof($actionPacketList)>1){

		return true;
		
	}
	return false;
	
}



}

?>