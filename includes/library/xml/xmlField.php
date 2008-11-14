<?
/* class xmlField {{{ */
/**
 * Represents a database field and display value
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package xml
 */
/* }}} */
class xmlField{

	var $dbField;
	var $displayName;
	
	function xmlField($dbField, $name){
		
		$this->dbField = $dbField;
		$this->displayName = $name;
		
	}
	
	function getDisplayField(){
		
		return $this->displayName;
		
	}
	
	function getDbField(){

		return $this->dbField;
		
	}
	
	
}


?>