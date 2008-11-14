<?
/* class javaScriptConstraint {{{ */
/**
 * represents a  JavaScript constraint
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package plan.javaScript
 */
/* }}} */
class javaScriptConstraint{

	var $elementName;
	var $constraint;
	
	function javaScriptConstraint($elementName='', $functionMode='', $value=''){
		
		$this->elementName = $elementName;
		
		debug::message('MODE:'.$functionMode);
		
		switch ($functionMode){
		
			case 'presence':
			
				$this->constraint = "!=''";
				break;
			
			case 'match':	
			
				$matchValue = $value[3]->toString();
				$this->constraint = "== '$matchValue'";
			
			
				break;
			
			case 'function':
			
				$functionPredicateValues = $value[3]->getPredicateValues();
				$predicateName = $value[3]->getPredicateName();

				debug::message('Function: '.$predicateName);
				
				switch($predicateName){
				
					case 'lessThan' :
					
						$this->constraint = '<' . $functionPredicateValues[0]->toString();
						break;
						
					case 'greaterThanOrEqual' :
					
						$this->constraint = '>=' . $functionPredicateValues[0]->toString();
						break;
						
				}			
			
		}
		
	}
	
	function getElementName(){
		
		return $this->elementName;	
		
	}
	
	
	function toString(){
		
		return ( "\"document.forms['iwfmsForm'].elements['".
					$this->elementName . 
					'\'].value'. 
					$this->constraint . 
					'"');	
		
	}
	
}


?>