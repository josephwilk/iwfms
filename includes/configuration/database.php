<?
require_once 'DB.php';
# USER DETAILS

function connect($db_name){

	if($db_name){
	
$user = 'root';
$pass = 'zakalwe';
$host = 'localhost';
//$db_name = 'iWFMS';

// Data Source Name: This is the universal connection string
$dsn = "mysql://$user:$pass@$host/$db_name";

// DB::connect will return a Pear DB object on success
// or a Pear DB Error object on error

// You can also set to TRUE the second param
// if you want a persistent connection:
// $db = DB::connect($dsn, true);

return DB::connect($dsn);

	}
	else{
		return false;
	}

}

$db = connect("iWFMS");

// With DB::isError you can differentiate between an error or
// a valid connection.

if (DB::isError($db)) {

        die ($db->getMessage());

}

?>