<?

/* class prologVar {{{ */
/**
 * Represents a prolog Var. Vars must begin with a upper case letter or _
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package prolog.dataStructures
 */
/* }}} */


//Variables in prolog must begin with a uppercase letter or an _

class prologVar{
	
	var $varName="";
	
	
	function prologVar($varName=""){
		
		if($varName!=''){
		
			if(ctype_alpha($varName[0])){
	
			
			//Ensure that a variable must always start with a capital letter 
			$this->name = strtoupper($varName);	
			
			}
			else{
				
				errors::errorMessage("Variables have to have the first letter as alphanumeric");	
				
				
			}
		}
		else{
		
				errors::errorMessage("Variables cannot be empty");					
			
		}
		
	}
	
	function type(){
		
		return 'var';	
		
	}
	
	function toString(){
	
		return $this->name;	
		
	}
	
}


?>
