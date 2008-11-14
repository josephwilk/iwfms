<?

$page = currentPage();

if( $page != 'index' && $page != '' ){ // This is not the index page
	
	if(! $_SESSION['valid_user'] ){
	
		include_once($root.'/includes/common/system_invalid_session.php');
	
		include_once($root.'/staticform/loginform.php');
	
		include_once($root.'/includes/common/system_footer.php');
		exit;
	}
}

?>