<?

/* class dbs {{{ */
/**
 * Deals with the functions required for database access
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 
 * @package core
 */
/* }}} */

class dbs{
		
	/**
	* @return Database handle
	* @param String $mydbname
	* @param String $myserver
	* @param String $myuser
	* @param String $mypass
	* @desc connect to DB
	*/
	function connectdb($mydbname,$myserver,$myuser,$mypass){
		
		// connect to db
		$connection = mysql_connect($myserver,$myuser,$mypass) or die("Couldn't connect to database.");
		// select relevant db
		$db = mysql_select_db($mydbname, $connection) or die("Couldn't select database.");
		return $db;
	}

	function fetchrecord($result){
	// post: r = array(record)

		$row = mysql_fetch_array($result);
		return $row;
	}
	

	/**
	* @return unknown
	* @param String $field
	* @param String $table
	* @param String $where
	* @param String $order
	* @param Integer $fetch
	* @desc Selects a record from the database in a number of ways
	*/
	function selrecord($field,$table,$where,$order,$fetch){
		
		$row='';	
		$sql = "SELECT $field FROM $table";
			
		if($where){
			$sql .= " WHERE $where";
		}
		if($order){
			$sql .= " ORDER BY $order";
		}

		debug::message($sql . '<br><br>');
				
		$result = mysql_query($sql) or die("Couldna select records - " . mysql_errno() . ": " . mysql_error());
		
		if($fetch == 1){// return all rows as arrays, packaged up in an array				
		
			$row = array();		
			for($index=0; ($aresult = dbs::fetchrecord_mode($result,MYSQL_ASSOC)); $index++){
				$row[$index] =  $aresult;
			}			
		}elseif($fetch == '2'){
		
			$row = dbs::fetchrecord_mode($result,MYSQL_NUM);
		
		}
		elseif($fetch == '3'){
							   // return all rows as values in an array
							   // only works when a single value is being fetched			
			$row = array();
			for($index=0; ($aresult = dbs::fetchrecord_mode($result, MYSQL_NUM)); $index++){
				$row[$index] = $aresult[0];
			}	
		}
		elseif($fetch == '4'){
		
			$row = dbs::fetchrecord_mode($result,MYSQL_ASSOC);
		
		}
		else{
			$row = $result;		
		}
		
		return $row;
		
	}

	
	// 

	/**
	* @return String/Integer/Array/Object
	* @param String $field
	* @param String $table
	* @param String $query
	* @desc select and return a single field from a table
	*/
	function selattribute($field,$table,$query){
	
		$result = dbs::selrecord($field,$table,$query,'0','3');
		return $result[0];
	}


	

	/**
	* @return unknown
	* @param Mysql resource $result
	* @param String $mode
	* @desc fetchs a row from a resource and returns it as an array - modes are (MYSQL_ASSOC|MYSQL_NUM|MYSQL_BOTH)
	*/
	function fetchrecord_mode($result,$mode){
	
		$row = mysql_fetch_array($result, $mode);
		return $row;
		
	}


	/**
	* @return Integer, primary key inserted
	* @param $table String
	* @param $valsarray Array
	* @param $showkey Boolean
	* @desc Inserts into the database using the passed array to define the values.
			Fills in empty spaces for any vars missing from passed array
 */
	function irrecord($table,$valsarray,$showkey){
			
		if($table && sizeof($valsarray)){
		
		$vals = '';	
					
		//Generate column names
		$cols = dbs::genfieldnames($table,$showkey);
		$cols = preg_replace('/`|\s/','',$cols);
		
		//Break up into an array
		$keyarray = arrays::array_explode($cols,",");
		
		//$valsarray_size = sizeof($valsarray);
		$valsarray_size = sizeof($keyarray);
			
		for($index=0; $index < $valsarray_size; $index++){
			
			if($index != 0){
				$vals .= ",";
			}
			
			$vals .=   "'" .$valsarray[$keyarray[$index]] . "'";					
			
		}

		$sql = "INSERT INTO `$table` (" . $cols . ") VALUES (" . $vals . ")";		
		
	
		debug::message($sql . '<br><br>');
	
			
		$result = mysql_query($sql) or die("Couldna execute record insert/replace - " . mysql_errno() . ": " . mysql_error());
		return mysql_insert_id(); 
		
		
		}
		return false;
		
	}


	
	function irrecordArray($table,$valsarray,$showkey){
			
		if($table && sizeof($valsarray)){
		
		$vals = '';	
					
		//Generate column names
		$cols = dbs::genfieldnames($table,$showkey);
		$cols = preg_replace('/`|\s/','',$cols);
		
		//Break up into an array
		$keyarray = arrays::array_explode($cols,",");
		
		//$valsarray_size = sizeof($valsarray);
		$valsarray_size = sizeof($keyarray);
		
		
		$sql = "INSERT INTO `$table` (" . $cols . ") VALUES";
		
		
		for($valueIndex=0; $valueIndex < sizeof($valsarray); $valueIndex++){
			
			$vals='';
			for($index=0; $index < $valsarray_size; $index++){
				
				if($index != 0){
					$vals .= ",";
				}
				
				$vals .=   "'" .$valsarray[$valueIndex][$keyarray[$index]] . "'";					
				
			}

			if($valueIndex != sizeof($valsarray)-1){
			
				$sql .= "(" . $vals . "),";	
			
			}
			else{
			
				$sql .= "(" . $vals . ")";		
				
			}
			
		}
			
		debug::message($sql . '<br><br>');
	
		$result = mysql_query($sql) or die("Couldna execute record insert/replace - " . mysql_errno() . ": " . mysql_error());
		return mysql_insert_id(); 
				
		}
		return false;
		
	}
	
	

	/**
	* @return void
	* @param String $table
	* @param Array $updatearray
	* @param String $key
	* @param String/Int/Object/Char $keyvalue
	* @desc update record with update sql constructed from array
	*/
	function updaterecord($table,$updatearray,$key,$keyvalue){
		
		GLOBAL $sql_debug;
				
		$updatearray_size = sizeof($updatearray);
		$keys = array_keys($updatearray);
		$values = array_values($updatearray);
		$update='';
		
		for($index=0; $index < $updatearray_size; $index++){
			$update .=  "`".$keys[$index] . "`='" . $values[$index] . "', ";
		}

		// remove the trailing comma
		$update[ strlen($update)-2 ] = ' ';
		$sql = "UPDATE `$table` SET " . $update . " WHERE $key='" . $keyvalue . "'";		
		if($sql_debug){		
			echo $sql . '<br><br>';
		}

		$result = mysql_query($sql) or die ("Couldn't update record - " . mysql_errno() . ": " . mysql_error());
	}


	

	/**
	* @return unknown
	* @param String $table
	* @param Boolean $primary
	* @desc generate the columns of an insert/ replace sql
	*/
	function genfieldnames($table,$primary){
		
		$cols='';
	
		$sql = "SELECT * FROM $table";
		$result = mysql_query($sql) or die("Couldna select records to name fields - " . mysql_errno() . ": " . mysql_error());
		$num = mysql_num_fields($result);
		if($primary == '0'){
			$p = 1;
		}else{
			$p = 0;
		}
		for ($i=$p;$i < $num; $i++){
			$name = mysql_field_name($result, $i);
			if ($i + 1 < $num){
				$cols .= $name . "`, `";
			}else{
				$cols .= $name;
			}	

		}
		$cols = "`".$cols."`";
		return $cols;
	}


		
	/**
 	* @return Integer
 	* @desc get the last insert id
	*/
	function getlast(){
	// pre: none
	// post: returns the last automatically generated value that was inserted into an AUTO_INCREMENT column

		$sql = "SELECT LAST_INSERT_ID();";
		$result = mysql_query($sql) or die("Couldna get id - " . mysql_errno() . ": " . mysql_error());
		$row = mysql_fetch_array($result);
		return $row;
	}


	// 

	/**
	* @return void
	* @param String $table
	* @param String $key
	* @param String $id
	* @desc delete records by id
	*/
	function delrecord($table,$key,$id){
	
		$sql = "DELETE FROM $table WHERE $key = '$id'";
		
		$result = mysql_query($sql) or die("Couldna execute record delete - " . mysql_errno() . ": " . mysql_error());
	
	}


	

	/**
	* @return void
	* @param String $table
	* @param String $details
	* @desc create a table
	*/
	function createtable($table,$details){
	
		$sql = "CREATE TABLE IF NOT EXISTS $table ($details)";
		$result = mysql_query($sql) or die("Couldna create the table - " . mysql_errno() . ": " . mysql_error());
	}

	/**
	* @return void
	* @param String $table
	* @desc drop a table
	*/
	function droptable($table){

		$sql = "DROP TABLE $table";
		$result = mysql_query($sql) or die("Couldna drop the table - " . mysql_errno() . ": " . mysql_error());
	}

	/**
	* @return Boolean
	* @param String $table
	* @param String $value
	* @param String $field
	* @desc See if a field exists in a DB
	*/
	function existence($table, $value, $field){
		
		$row = dbs::selrecord($field,$table, $field . "='". $value."'",'0','0');
		
		if(dbs::numrecords($row)){
		
			return true;
				
		}
		
		return false;	
		
	}


	/**
	* @return Boolean
	* @param String $table
	* @param String $where
	* @desc See if a field match sql query is in the DB
	*/
	function existence_complex($table, $where){
		
		$row = dbs::selrecord('*',$table,$where,'0','0');
		
		if(dbs::numrecords($row)){
		
			return true;
				
		}
		
		return false;	
		
	}


	/**
	
	* @return Integer
	* @param String $query
	* @desc Count records
	*/

	function numrecords($query){
		
		return mysql_num_rows($query);
	}

	/**
	* @return Integer
	* @param String $table
	* @desc Count rows in table
	*/

	function numrows($table){
		$key = dbs::getprimarykey($table);	
		$query = dbs::selrecord($key,$table,'0','0','0');
		$num = mysql_num_rows($query);
		return $num;
	}

	/**
	* @return Integer
	* @param String $query
	* @desc Count fields
	*/

	function numfields($query){
		$num = mysql_num_fields($query);
		return $num;
	}

	
	/**
	* @return String
	* @param String $table
	* @desc return the primary key of table
	*/
	function getprimarykey($table){
		
		$result = dbs::selrecord('*',$table,'0','0','0');
		
		$i = 0;
		while ($i < mysql_num_fields($result)) {
		
			$meta = mysql_fetch_field($result);
			if (!$meta) {
				errors::errorMessage("No information available<br />\n");
				
				mysql_free_result($result);
				return false;
			}
			
			//multiple_key: $meta->multiple_key
			//primary_key:  $meta->primary_key
			//unique_key:   $meta->unique_key
				
			if(!$meta->multiple_key && $meta->primary_key){
				   $primkey = $meta->name;	
				   mysql_free_result($result);
				   return $primkey;
			}
			elseif($meta->multiple_key){
				
				errors::errorMessage('Support for multiple keys is not setup');
			}
			$i++;
		}
		
	}

}

?>