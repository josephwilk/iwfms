<?
/* class xmlTable {{{ */
/**
 * Represents a database table 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package xml
 */
/* }}} */


class xmlTable{

	var $tableName;
	var $fields;
	
	
	function xmlTable($name){
		
		$this->tableName = $name;
		$this->fields = array();
		
	}
	
	function addField($field){

		array_push($this->fields, $field);
		
	}
	
	function getTableName(){

		return $this->tableName;
		
	}
	
	
	function getDbFields(){
		
		$result = array();
		
		$fieldsSize = sizeof($this->fields);
		for($index=0; $index < $fieldsSize;  $index++){
		
			array_push($result, $this->fields[$index]->getDbField() );	
			
		}	
		
		return $result;
		
	}
	
	
	function getDisplayFields(){
		
		$result = array();
		
		$fieldsSize = sizeof($this->fields);
		
		for($index=0; $index < $fieldsSize; $index++){
		
			array_push($result, $this->fields[$index]->getDisplayField() );	
			
		}	
		
		return $result;
		
	}
	
	
	
}

?>