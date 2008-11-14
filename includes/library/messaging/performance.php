<?
/* class performance {{{ */
/**
 * Messaging for performance output
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package messaging
 */
/* }}} */


class performance{

	function message($msg){
		
		$performanceMode = false;
		
		if($performanceMode){
		
			echo '<h3 class="debug">:&nbsp;'.$msg.': '. time::stoptiming() . '</h3>';
		
		}
		
	}
	
}

?>