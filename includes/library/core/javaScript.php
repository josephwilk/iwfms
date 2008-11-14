<?

/* class javaScript {{{ */
/**
 * Functions for generating JavaScript
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.javaScript
 */
/* }}} */

class javaScript{

function javascriptArray($predicates){
	
	$resultArray = array();

	for($index=0;$index<sizeof($predicates);$index++){
		
		$vals = $predicates[$index]->getPredicateValues();
				
		array_push($resultArray,$vals[1]->toString()); 	
		
	}
	
	return $resultArray;
}


function findJavaScriptActions($actionList){

	$result = array();
	
	for($index=0;$index<sizeof($actionList);$index++){

		if( $actionList[$index]->getPredicateName() == 'entry')
		
			array_push($result, $actionList[$index]);
		
	}
	return $result;
	
}


function PHPToJavaScript($varName, $array){

		
	$resultString="var $varName = Array();\n";
	
	for($index=0;$index<sizeof($array);$index++){
		
		$resultString .= $varName. '['.$index .'] = ' . '"' .$array[$index].'"' . ";\n"; 
				
	}
	
	return $resultString;

}


}

?>