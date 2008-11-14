<? 

$root="../";
$pageref ="admin_groups.php";
$sql_debug =true;

include_once('../includes/commonPages/system_header.php');

// Database setup variables
$table = "groups";
$key = "groupid";
$identifier = "name";

$mesg='';

if($process){
	
	switch($process){
	
		case 'delete' : 	
			dbs::delrecord($table,$key,$$key);
			$mesg = 'Deleted!';
			break;
	
		case 'add':
			$vals['name'] = $name;
			$vals['members'] = $groupmembers;
		
			dbs:: irrecord($table,$vals,false);
			$mesg = 'Added!';
			break;
						
	}
		
}


if (!isset($mode) || $mode == 'preview'){
	// show preview page
	include_once('preview/' . str_replace('.php','',$pageref) .'_preview.php');
}
elseif($mode == 'add' || $mode == 'edit'){	
	// show edit page
	include_once('edit/' . str_replace('.php','',$pageref) . '_edit.php');		
}

include_once('../includes/commonPages/system_footer.php');