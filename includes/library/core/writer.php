<?

/* class writer {{{ */
/**
 * Functions for writing files
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package core
 */
/* }}} */

class writer{
	
	function write($filename,$directory, $dataArray){
				
		if(sizeof($dataArray) && $directory!='' && $filename!=''){
	
			$directory = "C:/Program Files/Apache Group/Apache2/htdocs/iWFMS/" . $directory;
						
			$handle = fopen($directory . $filename, "w");	

			$keys = array_keys($dataArray);
	
			for($index=0; $index < sizeof($dataArray);$index++){
	
				if (!fwrite($handle, $dataArray[$keys[$index]])){
       				errors::errorMessage("Cannot write to file ($filename)");
       				return false;
	 			}
			}
		
			fclose($handle);
		
		}
		else{
		
			errors::errorMessage("No data was passed to write!");	
			return false;
		}
		
	}
}
	
	
	
	
	
	
?>