<?

/* class string {{{ */
/**
 * Functions for processing strings
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package core
 */
/* }}} */


class string{

	function match($item1,$item2, $selected){
	//pre:none
	//post: r = (item1 == item2)
	if($item1 == $item2){
		
		echo $selected;
		return true;
			
	}
	return false;
}
	
	function sentence($variable){
		$result = ucfirst(strtolower($variable));
		return $result;
	}

	function lowFirstChar($string){

		if($string!=''){
		
			$string[0]= strtolower($string[0]);
		
		}
		return $string;
		
	}
	
	
	function capital($variable){
		$result = ucwords(strtolower($variable)); 
		return $result;
	}

	function up($variable){
		$result = strtoupper($variable); 
		return $result;
	}

	function low($variable){
		$result = strtolower($variable); 
		return $result;
	}
	
	function is_caps($string){
	
		if(is_numeric($string)){
		
			return false;	
			
		}
	
		$string_length = strlen($string);
		$caps_string = strtoupper($string);
		
		for($index=0;$index < $string_length; $index++){
		
			
			
			if( ord($string[$index]) != ord($caps_string[$index]) ){
			
				return 0;	
				
			}
				
			
		}
		
		return 1;
			
	}	

}
?>