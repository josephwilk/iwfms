<?

function dbmanagement_simple($table, $key, &$keyvalue, &$mode, $process, $vals){

	GLOBAL $sql_debug;
		
	if ($process == 'delete'){
		// Delete the record from table
		dbs::delrecord($table,$key,$keyvalue);
				
		$mesg = DELETED;
		$mode = 'preview';

	}

	/* 
	process an insert / replace request 
	send the table name, the cols, the vals and the actual record id for a replace
	*/
	
	elseif ($process == 'add' || $process == 'edit'){
		
		// generate table column field names
		$cols = dbs::genfieldnames($table,'0'); 
		
		if (!empty($keyvalue)){
				
			/*
			this is an existing record 
			adjust the columns and values parts of the replace sql statement
			*/
					
			
					
			$cols = "`" . $key . "`, " . $cols;
			$vals = "'" . $keyvalue . "', " . $vals;
			$request = "REPLACE";
		}else{ 
			// this is a new record so set the insert sql statement				
			$request = "INSERT";
		}
			
		// run the sql for the live database
		
		echo $cols;
		echo $vals;
		
		
		
		
		dbs::irrecord($request,$table,$cols,$vals);
		
		$mesg = SAVED;
			
		// get the primary key for the previously inserted record
		if (empty($keyvalue)){
			$row = dbs::getlast(); 
			$keyvalue = $row[0];
		}
		// set return mode
		$mode = "edit";
	}
	return $mesg;
}

?>