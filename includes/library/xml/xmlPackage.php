<?
/* class xmlPackage {{{ */
/**
 *  Converts xml to object datastructures
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package xml
 */
/* }}} */

class xmlPackage{

	function package($xmlTree){
		
		if(isset($xmlTree[0])){
			
			$dataTreeAndMeta = $xmlTree[0]['_ELEMENTS'];
			$dataTree = $dataTreeAndMeta[0]['_ELEMENTS'];
			
			//DB name
			$xmlDb = new xmlDb( $dataTree[0]['_ELEMENTS'][0]['_DATA'] );
			
			//DB tables	
			for($index=1; $index < sizeof($dataTree[0]['_ELEMENTS']); $index++){
					
				$xmlDb->addTable( xmlPackage::__breakupContents($dataTree[0]['_ELEMENTS'][$index]['_ELEMENTS']) );	
				
			}
		}
		return $xmlDb;
		
	}
	

	function __breakupContents($dbTables){
	
		$dbTableFields = $dbTables[1]['_ELEMENTS'];
			
		$xmlTable = new xmlTable($dbTables[0]['_DATA']);
			
		//Parse DBField and DBDisplayName
		
		for($index=0; $index < sizeof($dbTableFields); $index= $index+2){
		
			$xmlField = new xmlField($dbTableFields[$index]['_DATA'], $dbTableFields[$index+1]['_DATA'] );
			
			$xmlTable->addField( $xmlField );
			
		}
			
		return $xmlTable;
		
	}
	
	
	function __testDatabaseFields($workflowIDs, $timeStamps, $xmlPackage, $valueMode){
		
		$workflowIDsSize = sizeof($workflowIDs);
		
		for($workflowIndex=0; $workflowIndex < $workflowIDsSize; $workflowIndex++){
		  			
			$newDataItem = new coreWorkflowDataPacket($workflowIDs[$workflowIndex], $timeStamps[$workflowIndex]);
					
			$tables = $xmlPackage->getTables();
			
			//For each table
			$tableSize = sizeof($tables);
			for($tableIndex=0; $tableIndex < $tableSize; $tableIndex++){
				
				$table = $tables[$tableIndex]->getTableName();
		
				$fields = $tables[$tableIndex]->getDbFields();
								
				$fieldsSize = sizeof($fields);
				
				//The fields specificed
				for($index=0; $index < $fieldsSize; $index++){
					
				 	$field  = $fields[$index];
								 	
						$sql_query = "workflowId='$workflowIDs[$workflowIndex]'";
						
						$dbvalue = dbpear::selAttribute($field,$table,"$sql_query");
						
						$newDataItem->addId($field);
						
						//False may be posted from db;
						if( $dbvalue!='false' && $dbvalue ){
							
							if($valueMode){//Store the value rather than presence
							
								$newDataItem->addValue($dbvalue);
								
							}
							else{
							
								$newDataItem->addValue(true);	
								
							}
							
							
						}
						else{//Store the value rather than presence
							
							if($valueMode){
							
								$newDataItem->addValue($dbvalue);
								
							}
							else{
							
								$newDataItem->addValue(false);
								
							}
														
						}
			  
		  		}
				 		
			}
			$db = connect( 'iWFMS' ); 	
			
			
			switch ($valueMode){
			
				case 'archive':
				
					workflowDisplayHTML::html_displayXMLArchive($newDataItem, false);
					break;
				
				case 'archiveView':
				
					workflowDisplayHTML::html_displayXMLArchive($newDataItem, true);
					break;
				
						
				case 'data':
				
					workflowDisplayHTML::html_displayXMLData($newDataItem);
					break;
				
					
				default:
					workflowDisplayHTML::html_displayXML($newDataItem);	
					break;				
				
			}
			
			$db = connect( $xmlPackage->getDb() ); 
		}	
		
		
	}
	
	
	
	function displayAll($xmlPackage, $table, $title){
		global $db;
		
		$workflowIDs = dbs::selrecord('workflowid',$table, '' ,0,3);	
		$workflowTimestamps = dbs::selrecord('timestamp',$table, '' ,0,3);	
		
		$db = connect( $xmlPackage->getDb() ); 
		debug::message("connect to db:" .$xmlPackage->getDb());
		
		workflowDisplayHTML::tableHead($xmlPackage->getDisplayFields(), "", $title);
		
		xmlPackage::__testDatabaseFields($workflowIDs,$workflowTimestamps, $xmlPackage, false);
				
		//workflowDisplayHTML::tableMainOpen();
			    		
		workflowDisplayHTML::tableMainClose();	
		$db = connect( 'iWFMS' );
	}
	
	
	function displayItem($xmlPackage,$workflowId, $table, $title){
		global $db;
		
		$workflowIDs = array($workflowId);
		$workflowTimestamp = dbs::selrecord('timestamp',$table, 'workflowId='.$workflowId ,0,3);	
		
		$db = connect( $xmlPackage->getDb() ); 
		debug::message("connect to db:" .$xmlPackage->getDb());
		
		workflowDisplayHTML::tableHead($xmlPackage->getDisplayFields(), "", $title);
		
		xmlPackage::__testDatabaseFields($workflowIDs,$workflowTimestamp, $xmlPackage, false);
				
		//workflowDisplayHTML::tableMainOpen();
			    		
		workflowDisplayHTML::tableMainClose();	
		$db = connect( 'iWFMS' );
	}
	
	
	function displayAllArchive($xmlPackage, $table,$title, $mode){
		global $db;
		
		$workflowIDs = dbs::selrecord('workflowid',$table, '' ,0,3);	
		$workflowTimestamps = dbs::selrecord('timestamp',$table, '' ,0,3);	
		
		$db = connect( $xmlPackage->getDb() ); 
		debug::message("connect to db:" .$xmlPackage->getDb());
		
		workflowDisplayHTML::archiveTableHead($xmlPackage->getDisplayFields(), "", $title);
		
		xmlPackage::__testDatabaseFields($workflowIDs,$workflowTimestamps, $xmlPackage, $mode);
				
		//workflowDisplayHTML::tableMainOpen();
			    		
		workflowDisplayHTML::tableMainClose();	
		$db = connect( 'iWFMS' );
	}
	
	function displayArchiveItem($xmlPackage,$workflowId,$table, $title, $mode){
		global $db;
		
		$workflowIDs = array($workflowId);
		$workflowTimestamp = dbs::selrecord('timestamp',$table, 'workflowId='.$workflowId ,0,3);	
		
		$db = connect( $xmlPackage->getDb() ); 
		debug::message("connect to db:" .$xmlPackage->getDb());
		
		workflowDisplayHTML::archiveTableHead($xmlPackage->getDisplayFields(), "", $title);
		
		xmlPackage::__testDatabaseFields($workflowIDs,$workflowTimestamp, $xmlPackage, $mode);
				
		//workflowDisplayHTML::tableMainOpen();
			    		
		workflowDisplayHTML::tableMainClose();	
		$db = connect( 'iWFMS' );
	}
	
	
	function displayAllData($xmlPackage ,$workflowID, $title){
		global $db;
		
		$db = connect( $xmlPackage->getDb() ); 
		
		debug::message("connect to db:" .$xmlPackage->getDb().'<br>');
		
		workflowDisplayHTML::dataTableHead($xmlPackage->getDisplayFields(), "",$title);
		
		//workflowDisplayHTML::tableMainOpen();
		
	    xmlPackage::__testDatabaseFields(array($workflowID),array(''), $xmlPackage, 'data');
		
		workflowDisplayHTML::tableMainClose();	
	}
	
}
?>