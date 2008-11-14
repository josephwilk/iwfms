<?

/* class coreWorkflowDataPacket {{{ */
/**
 * Used to hold data for the core index page
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package workflowDisplay
 */
/* }}} */


class coreWorkflowDataPacket{

	var $workflowId;
	var $date;
	var $ids = array();
	var $values = array();
	
	
	function coreWorkflowDataPacket($workflowId, $timeStamp){

		if($timeStamp !=''){
		
			$this->date = $timeStamp;
		}
			
		
		$this->workflowId = $workflowId;
		
	}
	
	function addId($id){
		
		array_push($this->ids, $id);
		
	}
	
	function addValue($value){
		
		array_push($this->values, $value);
		
		
	}
	
	function getworkflowid(){
		
		return $this->workflowId;	
		
	}
	
	function getData(){

		return $this->values;
		
	}
	
	function getDate(){

		return $this->date;
		
	}
	
}
?>