<?
/* class prologString {{{ */
/**
 * Represents a prolog string
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package prolog.dataStructures
 */
/* }}} */


class prologString{

	var $string;	

	function prologString($string=""){
		$this->string = $string;	
	}	
	
	function type(){
	
		return 'string';	
		
	}
	
	function toString(){
	
		//Remove all white space
		//$string = preg_replace("/\s/","",$this->string);
		
		return "'". $this->string. "'";	
	}
	
}
?>