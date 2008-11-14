<?php

include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$result = prolog::lookupUser($_SESSION['valid_user']);
echo 'Knowledge Base data:    ' . $result. '<br><br>';

$groups = groups::getUserGroupNames($_SESSION['valid_user']);


$xmlParser = new XMLtoArray("jobSpecification.xml");
$xmlTree = $xmlParser->process();

//Package the xml data
$xmlPackage= xmlPackage::package($xmlTree);


//Display the data as HTML
xmlPackage::displayAll($xmlPackage,'workflow','Active workflow');

echo '<br><br><br><br>';

xmlPackage::displayAllArchive($xmlPackage,'workflowarchive','Archived Workflow','archive');




include_once("includes/commonPages/system_footer.php");

?>