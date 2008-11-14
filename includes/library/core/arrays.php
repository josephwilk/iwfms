<?

/* class arrays {{{ */
/**
 * Deals with the processing of Arrays
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 
 * @package core
 */
/* }}} */
class arrays{

	
	function removeDuplicates($array){
	
		$noDuplicates = array();
		
		for($index=0; $index<sizeof($array);$index++){
			
			if(!arrays::member($array[$index], $noDuplicates)){
				
				array_push($noDuplicates, $array[$index]);
			
			}
		}
	
		return $noDuplicates;
		
	}

	
	
	/**
	* @return Integer
	* @param Array $array
	* @desc Sum array values
	*/
	function sum($array){
	//pre:
	//post:
		
		$accum=0;
		for($index=0;$index < sizeof($array); $index++){
	
			$accum += $array[$index];
			
		}
		return $accum;
			
	}
	
	
	/**
	* @return Value
	* @param Array $array
	* @param String $stringkey
	* @desc finds value in an array identified by the passed key
	*/
	function findintindex($array, $stringkey){
	//pre: is_array($array)
	//post: key matching the same value as stringkey

		while( $integerelement = each($array)){ 
				
			$stringelement =  each($array);
				
			if($stringkey == $stringelement['key']){
				
				return $integerelement['key'];	
					
			}
		}
		return false;
	}



	/**
	* @return String
	* @param Array $array
	* @desc Converts an array to database format
	*/
	function convert2dbvals($array){
		
		$number = count($array) / 2;
		$vals = "";
		for($i=0;$i<$number;$i++){
			if ($i==0){
				$vals .= "'" . $array[$i] . "', '";
			}elseif($i==$number-1){
				$vals .= $array[$i] . "'";
			}else{
				$vals .= $array[$i] . "', '";
			}
		}
				
		return $vals;	
	}

	
	
	/**
	* @return var
	* @param $arraySearch Array
	* @param $arraySearch Array
	* @desc checks array membership in arrays
 	*/
	function searchArray($arraySearch,$arrayCheck){

		for($index=0; $index < sizeof($arraySearch); $index++){
		
			if( arrays::member($arraySearch[$index],$arrayCheck ) ){
				
				return $arraySearch[$index];
			}
					
		}
		return false;
	}
	
	
	/**
	* @return Boolean
	* @param $number Integer/Char/String
	* @param $list Array
	* @desc checks array membership for multi-dimensional arrays
 	*/
	function member_multi($number, $list){
	
	
		if(!empty($list)){
			
			for($i=0;$i<count($list);$i++){	

				foreach($list[$i] as $alistitem){
					
					if($number == $alistitem){
							
						return true;			
					}		
				}
			}
			return false;
		}
	}
	
	/**
	* @return Boolean
	* @param $number Integer/Char/String
	* @param $list Array
	* @desc checks array membership
 	*/
	function member($number, $list){
		
		if(!empty($list)){

			foreach($list as $alistitem ){
				
				if($number == $alistitem){
						
					return true;			
				}		
			}
		}
		return false;	
	}

	function allEqual($array){

		$bool = true;
		
		if($array){
		
			$firstValue = $array[0];
			for($index=1;$index<sizeof($array) && $bool;$index++){
				
				$bool = ($array[$index] == $firstValue);
				
			}
		
		}
		return $bool;
		
	}
	
	
	
	
	
	/**
	* @return Bool
	* @param Array $array
	* @desc Checks if all values in array are set to true
	*/
	function forall($array){
	//pre: is_array(array)
	//post: Ax[ array(x) -> true == x ]
		
		$bool=true;
		for($index=0; $index < sizeof($array) && $bool; $index++){
			
			$bool = $array[$index];		
			
		}
		return $bool;
	
	}
	
	/**
	* @return Array
	* @param Array $array
	* @param String/Integer/Char $value
	* @desc Deletes a value from the array
	*/
		
	function array_del($array, $value){
	//pre:
	//post deletes a element based on matching the actual value	
		$resultindex=0;
		$resultarray =array();
		
		for($index=0; $index < sizeof($array); $index++){
			
			if($array[$index] != $value){
				
				$resultarray[$resultindex] = $array[$index];
				$resultindex++;
			}		
			
		}
				
		return $resultarray;	
		
	}
	
	/**
	* @return unknown
	* @param Array $array
	* @param String/Integer/Char $field
	* @param String/Integer/Char $value
	* @desc deletes an element based on matching a index's value in an array	
	*/
	function array_multidel($array,$field,$value){
				
		$resultindex=0;
		for($index=0; $index < sizeof($array); $index++){
			
			if($array[$index][$field] != $value){
				
				$resultarray[$resultindex] = $array[$index];
				$resultindex++;
			}		
			
		}
		return $resultarray;	
	}
	

	/**
	* @return array
	* @param $array array
	* @param $chopitem index to array
	* @desc Deletes index from the passed array	
 	*/
	function array_chop($array, $chopitem){
	

		$resultarray=array();
	
		$keyvalues = array_keys($array);
			
		$resultindex=0;
		for($index=0; $index < sizeof($array); $index++){
			
			if(is_int($chopitem)){//int key check
				
				$removeflag = ($index == $chopitem);
				
			}
			elseif( is_string($chopitem) ){// String key check
			
				$arrayindex = $keyvalues[$index];
				$removeflag = ($arrayindex == $chopitem);	
				
			}
			else{
			
				$removeflag = false;
					
			}	
			
			
			if(!$removeflag){
				
				$arrayindex = $keyvalues[$index];
				
				$resultarray[$resultindex] = $array[$arrayindex];
				$resultindex++;
			}		
			
		}
		
		return $resultarray;	
		
	}


	/**
	* @return Array
	* @param String $array
	* @param String $divider
	* @desc Explodes a string
	*/
	function array_explode($string,$divider){
		
		if($string !=''){
			$new_array = explode($divider,$string);
			return $new_array;
		}
	}



	/**
	* @return Integer
	* @param Char $char
	* @param Array $list
	* @desc Find the index of the char in the array
	*/
	function findindex($char,$list){
		
		if(!empty($list)){
		
			$index=-1;
			foreach($list as $item){
				
				$index++;			

				if($char == $item){
				
					return $index;
				}
					
			}
			return false;
		}
		return false;
	}

	
	
	/**
	* @return Array
	* @param Integer $start
	* @param Integer $end
	* @desc Generate a list of numbers
	*/
	function genlist($start,$end){

		$string = false;
	
		if(is_string($start) && is_string($end)){
	
			$start = ord($start);
			$end = ord($end);
			$string = true;
		}
			
		// PHP 4.03 has a bug, when incrementing chars in a For loop. ('ZZ' <= 'Z') && !('Z' <= 'Z')
		for($count = $start, $index = 0; $count <= $end; $count++, $index++){
			
			if($string){
				$result[$index] = chr($count); 	
			}
			else{
				
				$result[$index] = $count; 	
				
			}
	  	}
	  	return $result;
		
	}

	
	
}

?>