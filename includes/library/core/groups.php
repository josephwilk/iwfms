<?
/* class groups {{{ */
/**
 * Functions for processing groups
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package core
 */
/* }}} */

class groups{

	function getUserGroupNames($valid_user){
	
		$groupNames=array();
		
		$groups = unserialize( groups::getUserGroups($valid_user) );	
		
		for($index=0; $index < sizeof($groups); $index++){
		
			array_push($groupNames, groups::getgroupname($groups[$index]));
			
		}
		return $groupNames;
		
	}
	
	
	function getUserGroups($valid_user){	
	//pre: none
	//post: r = groupid
			
		global $sql_debug;
			
		return  dbs::selattribute('groups','users',"username='".$valid_user."'");
		
	}
	
	
	function getgroupname($groupid){

		$field = 'name';
		$key = 'groupid';
		$table = 'groups';
	
		return dbs::selattribute($field,$table,$key."='".$groupid."'");
		
	}
	
	
	
	
function getallmembers($groupid){
	
	$field = 'members';
	$resultsarray = array();
	
	if(is_array($groupid)){
			
		foreach($groupid as $group){
		
			$result = dbs::selrecord($field,'groups','groupid='.$group,'0','1');
			$memberlist = arrays::array_explode($result[$field],',');
			if($memberslist){
				array_merge($resultsarray,$memberlist);
			}			
		}		
		
	}else{
		
		$result = dbs::selrecord($field,'groups','groupid='.$groupid,'0','1');	
		$resultsarray = arrays::array_explode($result[$field],',');
		
	}

	return $resultsarray;		
}

}

?>