<?

/* class formdata {{{ */
/**
 * Functions for retrieving and manipulating data to be used in forms.
 * HTML should never occur in this file! Also all efforts must be made to include the logic in this file. 
 * The result should be returned in an array. The format of all arrays must be either:
 * - resultarray[array[0], array[1]] ~ where array[0][1..N] = relevant data
 * OR
 * - resultarray[0..N] = relevant data
 * Also ALWAYS put any setupdata in an array on the tail of the result array:
 * - resultarray[array[0], array[1], [array[2]] ~ where array[2][1..N] = setup data
 * Try and have consistent array indexes. For example 'name', 'value' and 'match' are used whenever possible
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package forminputs
 */
/* }}} */


class formdata{

	//Organising data for select boxes
	
	/**
	* @return Array
	* @param unknown $value
	* @param unknown $current
	* @param unknown $displayvalue
	* @desc pairs of select box values and display values packaged into an array with a true/false for a match to the current value
	*/
	function select_createpackage($value, $current, $displayvalue){
		
		$resultpackage['value'] = $value;
		
		if(!is_array($current)){		
			$resultpackage['match'] = string::match($value, $current, '');		
		}
		else{
			$resultpackage['match'] = arrays::member($value, $current);				
		}

		$resultpackage['displayvalue'] = $displayvalue;	
		return $resultpackage;
	}


	
																		  
	/**
	* @return array
	* @param unknown $dbfield
	* @param unknown $displayfield
	* @param unknown $current
	* @param unknown $populate
	* @param unknown $populatevalues
	* @param unknown $where
	* @param unknown $orderby
	* @desc get the select box data from a database or an array
	*/
	function getdata_select($dbfield, $displayfield, $current, $populate, $populatevalues, $where, $orderby){
		
		$index=0;
		if(!is_array($populate)){ // populate from table
			
			$rows = dbs::selrecord($dbfield . ',' . $displayfield ,$populate,$where, $orderby ,'0'); 
		
			if(dbs::numrecords($rows) !=0){// No results returned										
				while($row = dbs::fetchrecord($rows)){
														
					if(preg_match("/,/", $displayfield)){
						$display = '';
						$displays = explode(",",$displayfield);
						for($i=0;$i<count($displays);$i++){
							$display .= $row[$displays[$i]] . '&%&';
						}
					}else{
						$display = $row[$displayfield];
					}	
					$resultpackage[$index] = formdata::select_createpackage($row[$dbfield],$current,$display);
					$index++;
				}
			}else{
				$resultpackage = false;
			}
		}else{// populate from an array

			if(sizeof($populate) !=0){// no results returned										

				$popvalsindex = 0;
				foreach($populate as $element){			
					if($populatevalues){// an array has been provided to populate values

						$resultpackage[$index] = formdata::select_createpackage($element,$current,$populatevalues[$popvalsindex]);	

					}else{ // use the populate array as the values and the display values
						
						$resultpackage[$index] = formdata::select_createpackage($element,$current,$element);	
					}
					$index++;
					$popvalsindex++;
				}
			}else{
				$resultpackage = false;
			}
		}
		
		// all setup data goes here in the last element
		$resultpackage[$index]['optionname'] = $dbfield;
		return $resultpackage;
	}


	/**
	* @return Array
	* @param unknown $name
	* @param unknown $dbfield
	* @param unknown $displayfield
	* @param unknown $current
	* @param unknown $populate
	* @param unknown $populatevalues
	* @param unknown $where
	* @param unknown $orderby
	* @desc returns all data for a select box populated from a db table or array
	*/
	function getdata_select_extra($name,$dbfield,$displayfield,$current,$populate,$populatevalues,$where, $orderby){

		$index=0;
		if(!is_array($populate)){ // populate from table
			
			if($siteid && !$where){				
				$where = 'siteid='.$s_siteid;
			}elseif($where && $siteid){
				$where = ' AND siteid='.$s_siteid;
			}

			$rows = dbs::selrecord($dbfield . ',' . $displayfield ,$populate,$where, $orderby ,'0'); 
		
			if(dbs::numrecords($rows) !=0){// No results returned										
				while($row = dbs::fetchrecord($rows)){
					if(preg_match("/,/", $displayfield)){
						$display = '';
						$displays = explode(",",$displayfield);
						for($i=0;$i<count($displays);$i++){
							$display .= $row[$displays[$i]] . '&%&';
						}
					}else{
						$display = $row[$displayfield];
					}	
					$resultpackage[$index] = formdata::select_createpackage($row[$dbfield],$current,$display);
					$index++;
				}
			}else{
				$resultpackage = false;
			}
		}else{// populate from an array

			if(sizeof($populate) !=0){// no results returned										

				$popvalsindex = 0;
				foreach($populate as $element){			
					if($populatevalues){// an array has been provided to populate values

						$resultpackage[$index] = formdata::select_createpackage($element,$current,$populatevalues[$popvalsindex]);	

					}else{ // use the populate array as the values and the display values
						
						$resultpackage[$index] = formdata::select_createpackage($element,$current,$element);	
					}
					$index++;
					$popvalsindex++;
				}
			}else{
				$resultpackage = false;
			}
		}
		
		// all setup data goes here in the last element
		$resultpackage[$index]['optionname'] = $name;
		return $resultpackage;
	}


	/**
	* @return Array
	* @param unknown $bucket
	* @param unknown $current
	* @param unknown $value
	* @param unknown $displayvalue
	* @desc the updated array with the extra option added
	*/
	function add_option($bucket, $current, $value, $displayvalue){
					
		// remove the system data array
		$setupdata = array_pop($bucket);
			
		// create new option
		$resultpacket[sizeof($bucket)] = formdata::select_createpackage($value,$current,$displayvalue);
				
			
		$bucket = array_merge($resultpacket,$bucket);
		array_push($bucket,$setupdata);
		
		return $bucket;
		
	}



	

	/**
	* @return Array
	* @param unknown $dbfield
	* @param unknown $current
	* @desc get the data for a text box
	*/
	function getdata_text($dbfield, $current){
	
		$result['name'] = $dbfield;
		$result['value'] = $current;
		return $result;
	}


	

	/**
	* @return Array
	* @param unknown $name
	* @param unknown $dbfield
	* @param unknown $table
	* @param unknown $current
	* @desc get the data for a text box and also the maximum length of data that can be added to the input
	*/
	function getdata_text_extra($name, $dbfield, $table, $current){
	
		GLOBAL $mydbname;
		$result['name'] = $name;
		$result['value'] = $current;	
		//$result['fieldlen'] = dbs::getfieldlen($mydbname,$table,$dbfield);
		return $result;		
	}


	/**
	* @return Array
	* @param unknown $name
	* @param unknown $current
	* @desc get data for a textarea
	*/
	function getdata_textarea($name, $current){

		$result['name'] = $name;
		$result['value'] = $current;		
		return $result;
	}


	

	/**
	* @return Array
	* @param unknown $dbfield
	* @param unknown $current
	* @param unknown $value
	* @param unknown $displayvalue
	* @desc get the data for a checkbox
	*/
	function getdata_checkbox($dbfield, $current, $value ,$displayvalue){

		$result['name'] = $dbfield;
		
		if($displayvalue){		
			$result['displayvalue'] = $displayvalue; 		
		}
		
		$result['value'] = $value; 
				
		if(!is_array($current)){
			$result['match'] = match($current,$value,'');	
		}else{ // current is an array					
			$result['match'] = arrays::member($value,$current);			
		}
			
		return $result;	
	}

	
	

	/**
	* @return Array
	* @param unknown $name
	* @param unknown $dbfield
	* @param unknown $current
	* @param unknown $datasource
	* @param unknown $populate
	* @param unknown $where
	* @param unknown $orderby
	* @desc get the data for multiple checkboxes
	*/
	function getdata_checkboxs($name, $dbfield, $current, $datasource, $populate, $where, $orderby){

		if(!is_array($datasource)){ // populate values from a database
			//$datasource = table
			//$populate = display		
			$default = true; // first item assumed default
			$index=0;
			$checks = dbs::selrecord($dbfield . ',' . $populate,$datasource,$where,$orderby,'0');
			while($check = dbs::fetchrecord($checks)){
				$result[$index]['checkbox'] = formdata::getdata_checkbox($name, $current, $check[$dbfield], $check[$populate], $default);
				$default = false;
				$index++;
			}
		}else{ // populate values from an array 
		
			if(sizeof($datasource)!=0){
				
				$default = true; // first item assumed default
				$index=0;
				foreach($datasource as $populateitem){
					$result[$index]['checkbox'] = formdata::getdata_checkbox($name, $current, $populateitem, $populate[$index], $default);
					$default = false;
					$index++;
				}
			}else{
				$result = false;
			}
		}
		return $result;
	}


	

	/**
	* @return Array
	* @param unknown $name
	* @param unknown $current
	* @param unknown $value
	* @param unknown $displayvalue
	* @param unknown $default
	* @desc get data for a radio button
	*/
	function getdata_radiobtn($name, $current, $value, $displayvalue, $default){
	
		$result['value'] = $value;
		$result['name'] = $name;
		
		if($displayvalue){
			$result['displayvalue'] = $displayvalue;
		}
		
		if(!isset($current) && $default ){ //this is the default radio button
			$result['match'] = true;
		}elseif(isset($current) ){
			$result['match'] = match($current,$value,'') || match($current,'','');
		}
		return $result;
	}


	/**
	* @return unknown
	* @param unknown $name
	* @param unknown $dbfield
	* @param unknown $current
	* @param unknown $datasource
	* @param unknown $populate
	* @param unknown $where
	* @param unknown $orderby
	* @desc get the data for multiple radio buttons
	*/
	function getdata_radiobtns($name, $dbfield, $current, $datasource, $populate, $where, $orderby){
	
		if(!is_array($datasource)){ // populate values from a database table
			//$datasource = table
			//$populate = display
			$default = true; // first item assumed default
			$index=0;
			$radios = dbs::selrecord($dbfield . ',' . $populate,$datasource,$where,$orderby,'0');
			while($radio = dbs::fetchrecord($radios)){							
				$result[$index]['radiobtn'] = formdata::getdata_radiobtn($name, $current, $radio[$dbfield], $radio[$populate], $default);
				$default = false;
				$index++;
			}
		
		}else{ // populate values from an array 
		
			if(sizeof($datasource)!=0){
				
				$default = true; // first item assumed default
				$index=0;
				foreach($datasource as $populateitem){
					$result[$index]['radiobtn'] = formdata::getdata_radiobtn($name, $current, $populateitem, $populate[$index], $default);
					$default = false;
					$index++;
				}
			}else{
				$result = false;
			}
		}
		return $result;
	}


	

	/**
	* @return array
	* @param unknown $imageid
	* @param unknown $imagenumber
	* @desc image button data
	*/
	function getdata_imagebtn($imageid, $imagenumber){
	
		$result['value'] = $imageid;
		$result['name'] = 	getimagename($imageid);
		$result['imagenumber'] = $imagenumber;
				
		if(empty($imageid)){
			$result['empty'] = true;
		}else{
			$result['empty'] = false;
		}	
		return $result;	
	}

	
	

	/**
	* @return Array
	* @param unknown $type
	* @param unknown $name
	* @param unknown $value
	* @param unknown $onclick
	* @desc form button data button parameters
	*/
	function getdata_btn($type, $name, $value, $onclick){
	
		$result['value'] = $value;
		$result['name'] = $name;
		
		$result['onclick'] = $onclick;
		$result['type'] =  $type;
		
		return $result;
		
	}


	/**
	* @return unknown
	* @param unknown $name
	* @param unknown $current
	* @desc get date data for a Y-m-d selection
	*/
	function getdata_date($name,$current){
	
		$year = date("Y");

		if(!$current){// Set to default	
			$current = $mysql_today;
		}		
		list($datey,$datem,$dated) = explode('-',$current);	
		$result[0]['day'] = formdata::getdata_select($name.'d', 0, $dated, arrays::genlist(1,31),0,0,0);
		$result[0]['month'] = formdata::getdata_select($name.'m', 0, $datem, arrays::genlist(1,12),0,0,0);
		$result[0]['year'] = formdata::getdata_select($name.'y', 0, $datey, arrays::genlist(2000,2006),0,0,0);	
		return $result;		
	}

}

?>