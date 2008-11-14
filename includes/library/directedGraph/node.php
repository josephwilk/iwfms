<?

/* class node {{{ */
/**
 * collection of temporal orderings *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package directedGraph
 */
/* }}} */

class node{

	var $name = "";
	var $data;
		
	function node($name, $data){
		$this->name = $name;
		$this->data = $data;
	}
	
	function getName(){

		return $this->name;
		
	}
	
	function setData($data){
		$this->data = $data;
	}
	
	function getData(){

		return $this->data;
		
	}
	
	function toString(){

		if( sizeof($this->data) ){
			
			return $this->data[0]->toString();
		}
		return "emptyNode";
		
	}
	
	function getNodeData($node){

		return $node[0];
		
	}
	
	
}
?>