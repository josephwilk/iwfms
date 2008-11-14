<?session_start();
include_once('includes/configuration/core_configuration.php');


if( security::authenticateLogin($mode, $username,$password) ){
	
	$redirect = "home.php";
	$result='';
	
	//fetchGroups($jw99);
	//fetchForms($jw99);

	$groups = groups::getUserGroupNames($_SESSION['valid_user']);
		
	$forms = array();
		
	$username = strtolower($username);
	
	// Record that users groups and forms in the knowledge base
	$result = prolog::recordUser($username,$groups,$forms);
	
}
else{

	$redirect = "index.php?mode=failed";

}
header("Location:" . $redirect); 
?>