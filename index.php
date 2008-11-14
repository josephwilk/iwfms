<?php

//include_once('phpunit/phpunit.php');

include_once('includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

if ( (!isset($mode)) && !(isset($_SESSION['valid_user']) )){
	
	include("staticform/loginform.php");
	include_once("includes/commonPages/system_footer.php");
}
elseif($mode=='failed'){
	
	echo '<div align="center">';
	errors::errorMessage("Incorrect Username or password");
	echo "</div>";
	include("staticform/loginform.php");
	include_once("includes/commonPages/system_footer.php");
	
}
else{
	
	include("home.php"); 
	
}



?>