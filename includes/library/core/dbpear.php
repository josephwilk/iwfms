<?
/* class dbpear {{{ */
/**
 * Deals with processing sql in the Pear DB library
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package core
 */
/* }}} */
class dbpear{

	function selAttribute($field, $table, $sql_query){

		global $db;
		global $sql_debug;
	
		$sql = "select ".$field." from ".$table;
	
		if($sql_query){
	
			$sql .= " where " . $sql_query;
			
		}
		
		if($sql_debug){
		
			echo $sql;	
			
		}
		
		$result = $db->query($sql);

		if (DB::isError($result)) {
    		die ($result->getMessage());
		}

		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			
		return( $row[$field] );
	}
	
	function numRecords($table, $sql_query){
		
		global $db;
		global $sql_debug;
	
		$sql = "select * from ".$table;
	
		if($sql_query){
	
			$sql .= " where " . $sql_query;
			
		}
		
		if($sql_debug){
		
			echo $sql;	
			
		}
		
		$result = $db->query($sql);

		if (DB::isError($result)) {
    		die ($result->getMessage());
		}

		$rowCount = $result->numRows();
			
		return( $rowCount );
	
		
	}
	
	
}
?>