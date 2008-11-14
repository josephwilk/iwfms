<?

/* class systemMessages {{{ */
/**
 * deals with system messages *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package messaging
 */
/* }}} */

class systemMessages{


	function message($string){

		echo "<h3>$string</h3>";

	}

	function messageBoolean($bool){

		if($bool){
		
			echo "<h3>True</h3>";
			
		}
		else{
			
			echo "<h3>False</h3>";	
			
		}
		
		

	}
	
}
?>