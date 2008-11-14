<?

/* class xmlDb {{{ */
/**
 * Represents a database which a number of database tables
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package xml
 */
/* }}} */

class xmlDb{
	
	var $dbName;
	var $tables;
		
	/**
	* @return xmlDb
	* @param String $dbName
	* @desc Constructor
	*/
	function xmlDb($dbName){

		$this->dbName = $dbName;
		$this->tables = array();
	}
		
	/**
	* @return void
	* @param unknown $table
	* @desc Adds tables objects assocaited with this db
	*/
	function addTable($table){
	
		array_push( $this->tables, $table );
	
	}
	
	/**
	* @return String
	* @desc Returns the dbName
	*/
	function getDb(){
		
		return $this->dbName;	
		
	}
	
	/**
	* @return Array
	* @desc Fetchs the tables assocaited with this db 
	*/
	function getTables(){
		
		return $this->tables;
		
	}
	
	
	/**
	* @return Array
	* @desc Fetches all the fields associated with tables assocaited with this db
	*/
	function getDisplayFields(){
		
		$fieldList = array();
		
		
		$tablesSize = sizeof($this->tables);
		for($tableIndex=0; $tableIndex < $tablesSize; $tableIndex++){
	
			$currentTable = $this->tables[$tableIndex];
							
			$fieldList = array_merge($fieldList, $currentTable->getDisplayFields() );	
						
		}	

		return $fieldList;
		
	}
	
		
}
?>