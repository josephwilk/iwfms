<?
/* class prologAtom {{{ */
/**
 *  Represents a prolog Atom
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package prolog.dataStructures
 */
/* }}} */
class prologAtom{

	var $atom;	

	function prologAtom($atom=""){

		if($atom!=''){
		
			if(string::is_caps($atom[0])){
			
				$atom = string::lowFirstChar($atom);
				
			}
		}
			
		$this->atom = $atom;
			
	}
	
	function type(){
		return 'atom';
	}
	
	
	/**
	* @return String
	* @desc Convert this atom to string format	
 	*/
	function toString(){
	
		return $this->atom;	
				
	}
	
}
?>