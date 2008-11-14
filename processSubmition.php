<?
include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

if(  $_SESSION['posted'] ){//This form has been posted so prevent a refresh

	errors::errorMessage("The Form cannot be re-posted! Please go back to the home page");
	
	
}
else{

//Indicate the form has been posted
$_SESSION['posted'] = true;	

debug::transferFormPosts($_POST);

//Fetch the plans from the database
$planGraphList = graphPlanDatabaseAccess::getPlanGraphList($_POST['workflowID']);

$result = planAction::actOnPlan($planGraphList, "edgeProgression");
$plannerProgress[0] = $result['actionPackets'];

$match=false;
$edgeProgressionResult = true;
$goal=false;

$indexTest=1;
while(!$match && $edgeProgressionResult && !$goal){//Process all edgeProgression actions
		
	//Fetch the action packets
	$actionPackets = $plannerProgress[0]; 
	
	//Check the edgeprogression action has been matched
	$edgeProgressionPacket = planningAgent::action($actionPackets, $_POST );	
	
	//Retreive whether the edge progression test was passed
	$edgeProgressionResult = $edgeProgressionPacket['match'];
	
	//Retrive the selected action packet
	$selectedActionPacket = $edgeProgressionPacket['actionPacket'];
	
	if($edgeProgressionResult){//The edgeprogression test succeded
		
		//Check the chosen action packet
		if( $selectedActionPacket->atGoal() ){//At goal node
		
			$goal=true;
		
			planArchieving::archive($_POST['workflowID']); 
			
			systemMessages::message("Goal node reached!");
		
		}
		else{
	
			//Only one action packet should be returned
			$plans = $selectedActionPacket->getPlans();
			
			$newPlannerProgress = planAction::fetchNextAction($plans);

			$action = node::getNodeData($newPlannerProgress[1]);
			
			if($action->getPredicateName() != 'edgeProgression'){
				
				$match=true;
				
			}
			else{
				
				
			}
			
			$plannerProgress = $newPlannerProgress;
			$newPlannerProgress=array();
		}	
		
	}
		
}

debug::message("edge progression test :" . $edgeProgressionResult);

if($edgeProgressionResult){
		
	if(!$goal){//No point in updating plans if we have reached the goal
		planningAgent::updatePlans($plans);
	}
	$xmlParser = new XMLtoArray($_POST['formName'].'.xml');
	$xmlTree = $xmlParser->process();
	//Package the xml data into objects
	$xmlPackage= xmlPackage::package($xmlTree);
	//Display the data as HTML
	
	xmlDatabase::updateDatabases($xmlPackage, $_POST['workflowID'], $_POST, $goal);
	
}
else{//no progress
	
	errors::errorMessage("Progression to a new workflow stage failed!");

	$xmlParser = new XMLtoArray("jobSpecification.xml");
	$xmlTree = $xmlParser->process();

	//Package the xml data
	$xmlPackage= xmlPackage::package($xmlTree);

	//Display the data as HTML
	xmlPackage::displayItem($xmlPackage,$_POST['workflowID'],'workflow','Current workflow item');
		
	
}

}
include_once("includes/commonPages/system_footer.php");

?>