<?

/* class prologRule {{{ */
/**
 * represents a prolog rule
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package prolog.dataStructures
 */
/* }}} */


class prologRule{

	var $head;
	var $predicateCollection = null;
		
	function prologRule($head=null){
	
		$this->head = $head;
		$this->predicateCollection = new prologConstructCollection();

				
	}
	
	function addBodyConstruct($predicate){
		
		$this->predicateCollection->addConstruct($predicate);
		
	}
		
	function setXMLtype($type){
	
		$this->xmlType = $type;	
		
	}
	
	
	function delimiter(){
		
		return ':-';
		
	}
	
	function toString(){
	
		$predicateString ='';
		
		//Convert head of rule to string
		$predicateString = $this->head->toString();
			
		
		if(! $this->predicateCollection->isFact()){// This is not a fact so its a rule,  process its body
		
			$predicateString .= $this->delimiter() . $this->predicateCollection->toString();
		
		}
		
		//Ensure valid prolog terminatation
		return $predicateString . ".\n";
		
	}
	
	
}


?>