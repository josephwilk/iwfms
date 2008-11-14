<?

function logout(){

	
	if(isset($_SESSION['valid_user']) ){
	
		$currentUser = $_SESSION['valid_user'];
	
		$result = session_unregister("valid_user");
	
		session_destroy();
	
		if ($result){
	
			echo "logged out";
		
		}else{
			# in the event of problems terminating the session...
			echo "could not log you out";
		}
	}else{
		# in the event logout is pressed when not logged in
		echo "You are not logged in";
	}	
}


function loggedIn(){

	if (session_is_registered("valid_user")){
		# report back log-in details
		echo "Logged in : <b>" . $_SESSION['valid_user'] ."</b>";
	}
}



?>