<?php

/* class prologContextFreeGrammarRule {{{ */
/**
 * The prologContextFreeGrammarRule class represents a context-free grammar rule.
 *
  * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package prolog.dataStructures
 */
/* }}} */


class prologContextFreeGrammarRule extends prologRule{

	function prologContextFreeGrammarRule($head=null){
	
		$this->head = $head;
		$this->predicateCollection = new prologConstructCollection();

				
	}
		
	function delimiter(){
	
		return ' --> ';	
		
	}
	
	
}

?>