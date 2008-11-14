<?

include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$_SESSION['posted'] = false;

function formHead(){?>
	<FORM name="iwfmsForm" action="processSubmition.php" method="POST">
<?}

function formTail($workflowID, $formName, $group){?>

	<input type="submit" value="Submit form" onclick="var planTest = testPlans(false); var timeTest = validate(); return planTest&&timeTest;">
	<input type="submit" value="Submit form Logic" onclick="var planTest = testPlans(true); var timeTest = validate(); return planTest&&timeTest;">
	<input type="hidden" name="workflowID" value="<?= $workflowID ?>">
	<input type="hidden" name="formName" value="<?= $formName ?>">
	<input type="hidden" name="group" value="<?= $group ?>">
	
	</form>
<?}


function findContructionActions($actionList){

	$result = array();
	
	for($index=0;$index<sizeof($actionList);$index++){

		if( $actionList[$index]->getPredicateName() == 'createFormElement')
		
			array_push($result, $actionList[$index]);
		
	}
	return $result;
	
}



function databaseActions($databaseActions){

	if(sizeof($databaseActions)){//The form required data to be fetched from the database
	
		for($index=0;$index< sizeof($databaseActions); $index++){
		
			$predicateValues = $databaseActions[$index]->getPredicateValues();
		
			$xmlfile = $predicateValues[0]->toString() . '.xml';
			
			$xmlParser = new XMLtoArray($xmlfile);
			$xmlTree = $xmlParser->process();
	
			//Package the xml data
			$xmlPackage= xmlPackage::package($xmlTree);
	
			//Display the data as HTML
			xmlPackage::displayAllData($xmlPackage, $_GET['workflowID'],'Database Information');
					
		}
	}
}


function findDatabaseActions($actionList){

	$result = array();
	
	for($index=0;$index<sizeof($actionList);$index++){

		if( $actionList[$index]->getPredicateName() == 'databaseFetch')
		
			array_push($result, $actionList[$index]);
		
	}
	return $result;
	
}



//Fetch the plan list
$planGraphList = graphPlanDatabaseAccess::getPlanGraphList($_GET['workflowID']);

$result = planAction::actOnPlan($planGraphList, "formSubmission");


//Seperate the action list from the graph plans
$actionList = $result['actionList'];

$javaConstraints = $result['javaConstraints'];

//Convert constraints plans into Javascript arrays
$planString="\nvar planCollection = Array();\n";
for($index=0; $index < sizeof($javaConstraints); $index++){
	
	$planString .= $javaConstraints[$index]->toJavascriptArray($index);	
	
}

//Find all javaScript predicates and use order to dictate user entry
$javaScriptPredicates = javaScript::findJavaScriptActions($actionList);
$prologTimeLine =  javaScript::javascriptArray($javaScriptPredicates);


//Begin JAVAscript controls
?>


<SCRIPT>
<?= $planString ?>
<?= javaScript::PHPToJavaScript('timeline',$prologTimeLine);  ?>
</SCRIPT>
<SCRIPT src="javaScript/javaScriptPlanner.js">

</script>
<?

//Find all construction actions
$contructionActionList = findContructionActions($actionList);

//Find any database actions if any
$databaseActions = findDatabaseActions($actionList);

//Display database information if there is any
databaseActions($databaseActions);

formHead();

//Convert construction predicates to an array for writing to a file
$dataArray = prologPredicate::convertArrayPredicatesToString($contructionActionList, ".\n");



$filename = prolog::transferToProlog($_SESSION['valid_user'], $dataArray);
$form = prolog::exec('formGenerationCGI.pl','main',$filename);

//Out prologs form generation
?>

<hr size="1">
Workflow Form<hr size="1">
<table border="0" cellpadding="3" cellspacing="8" width="80%">
<tr>
<td>
<?= $form; ?>
</td></tr></table>
<br><hr size="1">

<?
formTail($_GET['workflowID'],$_GET['formName'], $_GET['group'] );

include_once("includes/commonPages/system_footer.php"); ?>