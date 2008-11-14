<?

/* class planArchieving {{{ */
/**
 * Deals with the archiving of workflow items
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan
 */
/* }}} */

class planArchieving{

	function removeWorkflowUnit($workflowID){
		
		$table = 'plans';
		$planValues = array();
		$planValues['workflowid'] = $workflowID; 
		
		dbs::delrecord($table,'workflowId', $workflowID);
		dbs::delrecord('workflow', 'workflowId', $workflowID);
					
	}
	
	function addArchiveWorkflowUnit($workflowID){

		$table = 'workflowArchive';
		$archiveValues = array();
		
		$archiveValues['workflowid'] = $workflowID; 

		$archiveValues['timestamp'] = dbs::selattribute('timestamp','workflow','workflowId='.$workflowID);
		
		$archiveValues['plan'] = addslashes(serialize(graphPlanDatabaseAccess::getPlanGraphList($workflowID)));
		
		
		
		//$planValues['state'] = addslashes(serialize($plans));
		dbs::irrecord($table,$archiveValues, false);
			
	}

		
		
		
	
	
	function archive($workflowID){
			
		planArchieving::addArchiveWorkflowUnit($workflowID);

		planArchieving::removeWorkflowUnit($workflowID);
			
		
	}
	
}

?>