<?

function generatePrologDTDtyping( $dtd ){
		
	$table="dtdFile";
	
	include_once(realpath('') . '/includes/configuration/core_configuration.php');
	
	//Load the pear library
	require_once 'XML_DTD/DTD.php';
	
		ob_implicit_flush(true);
		
		$path = ini_get('include_path');
		
		$dtd = 'w3cDtds/' . $dtd;
		
		ini_set('include_path', realpath('..') . ":$path");
		
		$formElements = array();
		$formElements[0] = 'select';
		$formElements[1] = 'option';
		$formElements[2] = 'textarea';
		$formElements[3] = 'input';
		
		$typeRulesArray = array(":- multifile attributetype/3.\n\n");
			
		
		for($index=0; $index<sizeof($formElements); $index++){
				
			$typeRule = dtd::findAttributes($formElements[$index],$dtd);		
			$typeRulesArray = array_merge($typeRulesArray ,$typeRule->toArray() );
				
		}
		
			
		for($index=0; $index < sizeof($typeRulesArray); $index++){
		
			echo "$typeRulesArray[$index]<br>";	
			
		}
			
		writer::write('typedefinitions.pl','cgi-bin/htmlTyping/',$typeRulesArray);
		
}			


		
?>
