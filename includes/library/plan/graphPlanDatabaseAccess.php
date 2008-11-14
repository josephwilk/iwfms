<?

/* class graphPlanDatabaseAccess {{{ */
/**
 * Deals with fetching a list of workflow graphs from the database 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan
 */
/* }}} */


class graphPlanDatabaseAccess{

	function getPlanGraphList($workflowID){

		$result =array();
		
		$table = 'plans';
		$where = 'workflowid='. $workflowID;

		$workflowPlan = dbs::selrecord('plan', $table,$where,false,3);

		$workflowPlanSize = sizeof($workflowPlan);
		
		for($index=0;$index < $workflowPlanSize; $index++){
		
				$result[$index] = unserialize(stripslashes($workflowPlan[$index]));
			
		}

		return $result;
	}
	
	function updatePlanGraphList($workflowID, $plans){

		$planValuesCollection = array();
		
		$table = 'plans';
		$planValues = array();
		$planValues['workflowid'] = $workflowID; 
		
		dbs::delrecord($table,'workflowId', $workflowID);

		
		$plansSize = sizeof($plans);
		for($index=0; $index< $plansSize; $index++){

			$planValues['plan'] = addslashes(serialize($plans[$index]));
			
			array_push($planValuesCollection, $planValues);
			
			//dbs::irrecord($table,$planValues, false);
	
		}
		
		dbs::irrecordArray($table,$planValuesCollection, false);
		
	}
	
	function savePlanState($plans, $workflowID, $formName){
		
		$table = 'workflowState';
		$planValues = array();
		
		$planValues['workflowid'] = $workflowID; 
		$planValues['formName'] = $formName; 

		$planValues['state'] = addslashes(serialize($plans));
		dbs::irrecord($table,$planValues, true);
			
	}
	
	function stateAlreadyUpdated($workflowID, $formName){
		
		$table = 'workflowState';
				
		$whereClause = "workflowid=".$workflowID ." AND formName='". $formName. "'";
		
		return dbs::existence_complex($table, $whereClause);
				
	}
	

	function getPlanState($workflowID, $formName){
		
		$table = 'workflowState';
		$where = 'workflowid='. $workflowID;

		$field = 'state';
		
		$workflowPlan = dbs::selrecord($field,$table,$where,false,2);

		return unserialize(stripslashes($workflowPlan[0]));
		
	}
	
	
}


?>