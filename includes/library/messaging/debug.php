<?

/* class debug {{{ */
/**
 * deals with debug messages *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package messaging
 */
/* }}} */

class debug{

	function println($data,$debugmode){

		if($debugmode){
		
			$data =  print_r( $data ); 	
			$text = substr($data, 0, strlen($data)-1);
			
			
			echo '<br><h3>' . $text . '</h3><br>';
			
		}
		
	}
	
	function message($msg){
		
		$debugMode = false;
		
		if($debugMode){
		
			echo '<h3 class="debug">&nbsp;DEBUG:&nbsp;'.$msg.'</h3>';
		
		}
		
	}
	
	function transferFormPosts($_POST){

		$keys= array_keys($_POST);
	
		for($count=0; $count < sizeof($_POST); $count++){
			
			debug::message($keys[$count]);
			debug::message('->');
			debug::message($_POST[$keys[$count]]);
			debug::message('<br>');
			
		}
		
	}

	

}

?>