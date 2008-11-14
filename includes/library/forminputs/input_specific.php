<?

/* class formdisplay {{{ */
/**
 * Specific functions for forms elements 
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package forminputs
 */
/* }}} */

function input_key($key,$keyvalue){
	
	// fetch the data
	$keydata = formdata::getdata_btn('hidden',$key, $keyvalue, 0);
		
	// display it
	formdisplay::display_btn($keydata,'default');
}


// unused
function input_user($valid_user){

	//Fetch the data
	$moduserdata = formdata::getdata_btn('hidden','modifiedby', $valid_user, 0);
				
	//Display it
	formdisplay::display_btn($moduserdata,'default');
}


function input_modified($today,$valid_user){ 
	
	//Fetch the data
	$moduserdata = formdata::getdata_btn('hidden','modifiedby', $valid_user, 0);
	$modatedata = formdata::getdata_btn('hidden','modified', $today, 0);
			
	//Display it
	formdisplay::display_btn($moduserdata,'default');
	formdisplay::display_btn($modatedata,'default');
}



?>