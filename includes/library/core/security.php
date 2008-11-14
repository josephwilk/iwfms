<?

/* class security {{{ */
/**
 * Functions for checking the users when they login
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package core
 */
/* }}} */
class security{

	/**
	* @return Boolean
	* @param String $mode
	* @param String $username
	* @param String $password
	* @desc Checks the users password and if valid adds their username to the session
	*/
	function authenticateLogin($mode, $username,$password){

		if ($mode == 'login'){
	
			// encode password to check against what's stored in the db
			//$password = dbs::passencdec($password,$salt,'1');
	
			// query database to authenticate user - check username / password combo
			$result = dbs::selrecord('*','users',"username = '" . $username . "' and password = '" . $password . "'",'0','1');
	
			// check if an entry exists in the db
			if ( sizeof($result) ){
		
				// password/username authenticated - register the user session
		 		
				$_SESSION['valid_user'] = $result[0]['username'];
		 		$_SESSION['authentic_user'] = true;
		 		
				 				
				return true;
				
			}
			else{

				return false;
						
			}
  		}
  		else{
  		
  			return false;	
  			
  		}
	}

}

?>