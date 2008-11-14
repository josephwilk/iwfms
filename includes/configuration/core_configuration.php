<?
// prevent any client-side caching
header("Expires: Sat, 10 May 2003 00:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0


// URL information

function getURL(){
	
	GLOBAL $HTTP_HOST;
	GLOBAL $REQUEST_URI;
	
	return  "http://{$HTTP_HOST}{$REQUEST_URI}";
}

function getURLData($type){

		$URL = getURL();
		$urlPacket = parse_url($URL); 		
		return $urlPacket[$type];
}
	
function currentPage(){

	$match=array();
	
	$path= getURLData('path');
	
	$page = preg_match('/[.]*[^\/]*$/',$path,$match);
	$pageref = $match[0];
	return preg_replace('/.php/','',$pageref);
	
}

$root = "C:/Program Files/Apache Group/Apache2/htdocs/iwfms/";

include_once($root.'includes/configuration/database.php');
include_once($root. 'includes/configuration/core_includes.php');


// set date and time stuff

$today = gmdate("d-m-y");
$mysql_today = gmdate("Y-m-d");
$time = date("H:i");
$time_full = date("H:i:s");
$year = date("Y");
$modified = time::ts_unix_mysql(time::timestamp());

?>