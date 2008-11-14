<?
/* class xmlDatabase {{{ */
/**
 * Functions for updating database from XML
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package xml
 */
/* }}} */
class xmlDatabase{
	
	function updateDatabases($xmlPackage, $workflowId, $formData,$goal){
		
		global $db;
		
		$db = connect( $xmlPackage->getDb() ); 
		
		debug::message("connect to db:" .$xmlPackage->getDb().'<br>');
		
		$newDataItem = new coreWorkflowDataPacket($workflowId, array());
	    
		$tables = $xmlPackage->getTables();
		
		if(sizeof($tables)>0){
		
			//For each table
			for($tableIndex=0; $tableIndex < sizeof($tables); $tableIndex++){
			
				$table = $tables[$tableIndex]->getTableName();
						
				$valsArray['workflowId'] = $workflowId;
				
				$fields = $tables[$tableIndex]->getDbFields();
							
				//The fields specificed
				for($index=0; $index < sizeof($fields); $index++){
					
				 	$field  = $fields[$index];
					
					$valsArray[$field] = addslashes($formData[$field]);
														
				}
				
				//Does this workflow item already exist in the table
				$sql_query = "workflowId='$workflowId'";
					
				if( dbpear::numRecords($table,"$sql_query") ){
		
					$keyName = dbs::getprimarykey($table);
					$keyValue = dbpear::selAttribute($keyName,$table, $sql_query);
					
					dbs::updaterecord($table, $valsArray, $keyName, $keyValue);
				
				}
				else{
				
					dbs::irrecord($table,$valsArray, false);
					
					
				}
			
			$db = connect('iWFMS'); 	
				
			}
			
			$xmlParser = new XMLtoArray("jobSpecification.xml");
			$xmlTree = $xmlParser->process();

			//Package the xml data
			$xmlPackage= xmlPackage::package($xmlTree);

			if(!$goal){//We are not at the goal node
			
				//Display the data as HTML
				xmlPackage::displayItem($xmlPackage,$workflowId,'workflow','Current workflow item');
			
			}
			else{//We are at the goal node

				xmlPackage::displayArchiveItem($xmlPackage,$workflowId,'workflowArchive','Current archived workflow item','archive');
				
			}
			
		}
		else{
		
			$xmlParser = new XMLtoArray("jobSpecification.xml");
			$xmlTree = $xmlParser->process();

			//Package the xml data
			$xmlPackage= xmlPackage::package($xmlTree);

			//Display the data as HTML
			xmlPackage::displayItem($xmlPackage,$workflowId,'workflow','Current workflow item');
					
		}
		
		
	}

}
?>