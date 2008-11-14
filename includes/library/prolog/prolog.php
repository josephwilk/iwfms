<?
/* class prolog {{{ */
/**
 * Deals with calling prolog as CGI and passing information between the two through temporay files 
 *
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by Joseph Wilk
 * @package prolog
 */
/* }}} */
class prolog{
	
	
	function transferToProlog($username, $dataArray){
		
		//Generate filename
		$filename = sha1($username . date('U') );	
		
		writer::write($filename,'cgi-bin/transfer/' ,$dataArray);
			
		return $filename;
		
	}
	
	function cleanupDataSource($dataSource){
		
		$dir = 'C:/Program Files/Apache Group/Apache2/htdocs/iwfms/cgi-bin/transfer/';
		
		if($dataSource){
			
			unlink($dir . $dataSource);
		}
		
	}
	
			

	function exec($script, $goal, $dataSource){
		
		$bufferoutput ="";
		$cgibin = 'C:/Program Files/Apache Group/Apache2/htdocs/iwfms/cgi-bin/';
		
		$path = $cgibin . $script;
		
		if($dataSource){
				
				debug::message('sicstus --goal ini(\''.$dataSource.'\'),'.$goal.'. -l "'.$path.'"');
			
				$bufferoutput = `sicstus --goal ini('$dataSource'),$goal. -l "$path"`;
										
				prolog::cleanupDataSource($dataSource);
				
		}
		else{
			
				debug::message('sicstus --goal '.$goal.'. -l "'.$path.'"');
			
				$bufferoutput = `sicstus --goal $goal. -l "$path"`;
		}
					
		return $bufferoutput;
		
	}
	
	function transferFormPosts(){

		$keys= array_keys($_POST);

		for($count=0; $count < sizeof($_POST); $count++){
		
			echo $_POST[$keys[$count]];
		
		}
		
	}
	
	function transferUrlPosts(){
		
		$keys= array_keys($_GET);

		for($count=0; $count < sizeof($_GET); $count++){
		
			echo $_GET[$keys[$count]];
		
		}
	}
	

	
	function recordUser($username, $groups, $forms){
		
		$script = 'knowledgeBaseCGI.pl';
		$action = 'addUser';
		
		$constructList = new prologConstructCollection();
				
		for($index=0;$index < sizeof($groups); $index++){
		
			$groupPredicates[0] = new prologString($username);
			$groupPredicates[1] = new prologList('['.$groups[$index].']');
			
			//Add predicate to construct collection
			$constructList->addConstruct( new prologPredicate('get_post_value', $groupPredicates) );
						
		}
					
		$groupsList = $constructList->toArray();
		
		//print_r($groupsList);
		
		$filename = prolog::transferToProlog($username, $groupsList);
				
		return prolog::exec($script,$action, $filename);
		
	}
	
		
	function lookupUser($user){

		$script = 'knowledgeBaseCGI.pl';
		$action = 'lookup';
		
		debug::message($user);

		$user = string::low($user);
		
		$groupPredicates[0] = new prologString($user);
		
		$constructList = new prologConstructCollection();	
		
		//Add predicate to construct collection
		$constructList->addConstruct( new prologPredicate('get_post_value', $groupPredicates) );
							
		$userList = $constructList->toArray();
		
		$filename = prolog::transferToProlog($user, $userList);
		
		return prolog::exec($script,$action, $filename);
		
	}
	
		
	
}
?>