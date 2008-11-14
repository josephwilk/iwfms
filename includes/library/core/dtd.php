<?

/* class dtd {{{ */
/**
 * Deals with the converting of DTDs to prolog rules
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package core
 */
/* }}} */

class dtd{

	function findAttributes($formElement,$dtd){
		
		if($formElement!='' && preg_match('/\.dtd/',$dtd)){//No invalid paramaters
				
			$dtdParser = new XML_DTD_Parser;
			
			$dtdTree = $dtdParser->parse($dtd);
		
			if(sizeof( $dtdTree->dtd )){//No XML was found
			
				$typeRule = new typeRule($formElement);
				$typeRule->setRegularExpression( $dtdTree->getDTDRegex($formElement) );
				$typeRule->setChildren( $dtdTree->getchildren($formElement) );
		
				$attributeData = $dtdTree->getAttributes($formElement);
			
				$attributes = array_keys($attributeData);
			
				for($count=0; $count < sizeof($attributes); $count++){
								
					$headVars[0] = new prologAtom($formElement);
					$headVars[1] = new prologAtom($attributes[$count]);
					$headVars[2] = new prologVar('Value');
					
					//Create Predicate
					$head = new prologPredicate('attributetype', $headVars);
					
					//Create new prolog rule
					$dtdRule = new prologRule( $head );
							
					if( is_array($attributeData[$attributes[$count]]['opts']) ){ // There may be precondtions associated with this clause
					
						if( $attributeData[$attributes[$count]]['opts'][0] !=$attributes[$count] ){ //The precondtion is redundant
						
							for($optionsIndex=0; $optionsIndex < sizeof($attributeData[$attributes[$count]]['opts']); $optionsIndex++){
						
								$equalityTest = new prologExpression(new prologVar('Value'),
																					  new prologAtom($attributeData[$attributes[$count]]['opts'][$optionsIndex]), 
																					  'equality');
								
								$dtdRule->addBodyConstruct($equalityTest);
							
							}
						
						}else{ //The value of the attribute is its name
						
							
							
						}
							
					}
					else{
								
						$type = explode("-", $attributeData[$attributes[$count]]['opts'] );
						
						if(isset($type[1])){
						
							preg_match("/ImportedName\((.*)\)/", $type[1],$match);
							
							$xmlTypeVals[0] = new prologVar('Value');
							
							
							switch($match[1]){
								
								
								case 'Number':
							
									$xmlType = new prologPredicate( $match[1], $xmlTypeVals  );
									$dtdRule->addBodyConstruct($xmlType);
									break;
							}	
							
						}
						
						$dtdRule->setXMLtype($type[0]);
						
					}
				
					$typeRule->addClause($dtdRule);
					
				}
				
				return $typeRule;
			}
			else{
				return false;
			}
		}
		else{
		
			return false;	
			
		}
		
		
	}

}





?>