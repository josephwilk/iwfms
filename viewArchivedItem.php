<?php

include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$result = prolog::lookupUser($_SESSION['valid_user']);
echo 'Knowledge Base data:    ' . $result. '<br>';


$groups = groups::getUserGroupNames($_SESSION['valid_user']);

echo '<br>';

$xmlParser = new XMLtoArray("jobSpecification.xml");
$xmlTree = $xmlParser->process();

//Package the xml data
$xmlPackage= xmlPackage::package($xmlTree);

xmlPackage::displayArchiveItem($xmlPackage,$workflowID,'workflowarchive','Archived Workflow','archiveView');

include_once("includes/commonPages/system_footer.php");

?>