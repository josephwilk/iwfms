<?

/* class GraphConversion {{{ */
/**
 * Class for dealing with the conversion of String prolog into directed graphs
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package directedGraph
 */
/* }}} */


class GraphConversion{

	function convertStringPrologPlansToGraphs($prologPlans){
	
				
		//Clean plan for regular expressions processing
		$plans = prologPlanCollection::preparePlans($prologPlans);
	
		//Generate an array of all plans and their timepoints
		$plansAndTemporalOrderings =  prologPlanCollection::organisePlans($plans);
			
		//Convert plans and ordering into a directed graphs
		
		$plansAndTemporalOrderingsSize = sizeof($plansAndTemporalOrderings);
		for($index=0;$index<$plansAndTemporalOrderingsSize;$index++){
			
			$orderingCollection = $plansAndTemporalOrderings[$index]['ordering'];
			$planCollection = $plansAndTemporalOrderings[$index]['plan'];
		
			$planGraphList[$index] = graphPlan::convertToGraphPlan($orderingCollection, $planCollection);
			flush();
		}
		
		return $planGraphList;
		
	}
	
}	
	
?>