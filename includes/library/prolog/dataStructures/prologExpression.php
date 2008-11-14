<?

/* class prologExpression {{{ */
/**
 * The prologExpression class represents a prolog expression.
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package prolog.dataStructures
 */
/* }}} */

class prologExpression{

	var $equality = "";
	
	var $element1;
	var $element2;
	
	var $type="";
	
	function prologExpression($element1="",$element2="", $type=""){
	
		if($element1 !='' && $element2 !='' && $type !=''){ 
		
		$this->element1 = $element1;
		$this->element2 = $element2;
		
		$this->type = $type;
		
		$this->equality = '==';
		
		}
		else{
			
			errors::errorMessage('Expressions cannot be empty!');	
			
		}
					
	}
	
	function type(){
		
		return 'expression'	;
		
	}
	
	
	function toString(){
		
		if($this->element1 != '' && $this->element2 != ''){
		
			$object1 = $this->element1->toString();
			$object2  = $this->element2->toString();
			
			switch($this->type){
				
				case 'equality':
					$operator = $this->equality;
					break;
			}
			
			return $object1 . $operator . $object2; 	
			
		}
		
	}


}