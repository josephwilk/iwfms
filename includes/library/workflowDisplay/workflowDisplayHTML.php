<?

/* class workflowDisplayHTML {{{ */
/**
 * Functions for processing HTML for display workflow items
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package workflowDisplay
 */
/* }}} */
class workflowDisplayHTML{

	/**
	* @return void
	* @param CoreWorkflowDataPacket $coreWorkflowDataPacket
	* @desc Display html for packet
	*/
	function html_displayXMLData($coreWorkflowDataPacket){
		
		$tdClass = 'helpBod';
		
		?>


  	<tr> 
    	<td class="<?= $tdClass ?>"  width="40"><?= $coreWorkflowDataPacket->getworkflowid() ?></td>
    <?
    
    $data = $coreWorkflowDataPacket->getData();

    for($index=0;$index < sizeof($data); $index++){
 		
    	echo '<td class="'. $tdClass.'" width="100">';
    
    	if( $data[$index] ){
    
    		echo stripslashes($data[$index]);
    	
    	}
    	else{
    	
    		echo '&nbsp;';
    		
    	}
    
   		echo "</td>";
   
   		    
    }?>		
    
  

<?}





/**
	* @return void
	* @param CoreWorkflowDataPacket $coreWorkflowDataPacket
	* @desc Display html for packet
	*/
	function html_displayXMLArchive($coreWorkflowDataPacket,$showValues){
    
		$tdClass = 'helpBod';
				
		if($showValues){
    	
			workflowDisplayHTML::html_displayXMLData($coreWorkflowDataPacket);
		?> <td class="<?= $tdClass ?>"> <?= time::arrangedate($coreWorkflowDataPacket->getDate()) ?> </td> 
			<td class="<?= $tdClass ?>">&nbsp;</td><?
			
		}
		else{
			$data = $coreWorkflowDataPacket->getData();
			workflowDisplayHTML::workflowState($coreWorkflowDataPacket->getWorkflowId(),$data,true);
		
			
 ?>    
   <td class="<?= $tdClass ?>"> <?= time::arrangedate($coreWorkflowDataPacket->getDate()) ?> </td>   
   <td class="<?= $tdClass ?>"> <a href="viewArchivedItem.php?workflowID=<?= $coreWorkflowDataPacket->getWorkflowId() ?>">View</a> </td>
  </tr>

  
<?
		}
}

	
/**
 * @return void
 * @param CoreWorkflowDatPacket $coreWorkflowDataPacket
 * @desc Displays the HTML for the each workflow item
*/
function html_displayXML($coreWorkflowDataPacket){
	
	$tdClass = 'helpBod';
	
	
	$planGroups=array();
	$formName ='';
	
	workflowDisplayHTML::workflowState($coreWorkflowDataPacket->getWorkflowId(), $coreWorkflowDataPacket->getData(), false);	
    
    //Fetch plans from the database 
    $planGraphList = graphPlanDatabaseAccess::getPlanGraphList($coreWorkflowDataPacket->getworkflowid());
        
    $possibleActions = actionPacket::processLoop($planGraphList,$coreWorkflowDataPacket->getworkflowid());
    
    if(sizeof($possibleActions)){//Actions have been fouund
       
       	$possibleActionsSize = sizeof($possibleActions);
    	for($actionPacketIndex=0; $actionPacketIndex < $possibleActionsSize; $actionPacketIndex++){
    	    
    		$currentAction = $possibleActions[$actionPacketIndex]->getAction();

    		$data = $currentAction->getData();
			
			$entryTimepoint = $currentAction->getName();
		
			$vars = $data[0]->getPredicateValues();
		
			$formName =  $vars[0]->toString();
			$workflowCreator = $vars[1]->toString();
			
			//Convert into string form
			array_push($planGroups, $vars[2]->toString());

			//Check if this is a loop re-entry point		
			if($possibleActions[$actionPacketIndex]->checkForLoopReentry($entryTimepoint)){
				
				//Check we have not already save the state
				if( ! graphPlanDatabaseAccess::stateAlreadyUpdated($coreWorkflowDataPacket->getworkflowid(), $formName)){

					graphPlanDatabaseAccess::savePlanState($planGraphList, $coreWorkflowDataPacket->getworkflowid(), $formName);
										
				}			
				
			}
				
    	}
    	
    	//Fetch the groups the user is a member of
		$groups = groups::getUserGroupNames($_SESSION['valid_user']);
		
		$groupString="";
		$superuser =false;
		//Compare against the groups specified in the plans
		
		$groupsSize= sizeof($groups);
		for($index=0; $index < $groupsSize; $index++){
	
			if($groups[$index] == 'superuser'){
			
				$superuser = true;
			
			}
			else{
			
				$groupString .= $groups[$index];	
				
			}
			
			
			
		}
		
		if(! $superuser){
		
			$match =  arrays::searchArray($planGroups, $groups);
	
		}
		else{
		
			$match = $planGroups[0];
			
		}?>
		
	<td class="<?= $tdClass?>" width="172"><?= string::sentence($formName) ?></td>
        
	<td class="<?= $tdClass?>" width="100"> <?= string::sentence($workflowCreator) ?> </td>
        
	<td class="<?= $tdClass?>"> <?= time::arrangedate($coreWorkflowDataPacket->getDate()) ?> </td>

	<?	
		
		workflowDisplayHTML::buttons($coreWorkflowDataPacket->getWorkflowId(), $match, $planGroups, $formName);	   	
	
	}

}
	

function workflowState($workflowID, $data, $mode){

	$tdClass = 'helpBod';
	
	
?>
	
  	<tr> 
    	<td class="<?= $tdClass ?>" width="40"><?= $workflowID ?></td>
    <?
            
    for($index=0;$index < sizeof($data);$index++){
 		
	    echo '<td class="'.$tdClass.'" width="100">';
	
	    if( $data[$index] !='' ){
	    
	    	echo '<img alt="Form element completed" src="images/corepage/valid.gif">';
	    	
	    }
	    else{
	    
	    	if($mode){
	    	
	    		echo '<img alt="field was not used" src="images/corepage/cross.gif">';
	    	
	    	}
	    	else{
	    	
	    		echo '<img alt="Form element to be completed" src="images/corepage/invalid.gif">';
	    			
	    	}
	    	
	    }
	    
	    echo "</td>";
	        
    }		

	
}


function buttons($workflowID, $match, $planGroups, $formName){
	
	$tdClass = 'helpBod';
	$tdButtonClass = 'helpHedButton"';
	
	?>
	


	<? if(!$match){ ?>
	
    	<td class="<?= $tdClass ?>">&nbsp;&nbsp;&nbsp;<a onclick="alert('You are not a member of: <?= implode(' or ',$planGroups) ?>'); return false"  href="generateForm.php?group=staffNurse&formName=<?= $formName ?>&workflowID=<?= $workflowID ?>">Edit</a></td>
    
    <?}
    else{?>
    
		<td class="<?= $tdClass ?>">&nbsp;&nbsp;&nbsp;<a onclick="alert('You are a member of: <?= implode(' or ',$planGroups)?>');"  href="generateForm.php?group=<?= $match?>&formName=<?= $formName ?>&workflowID=<?= $workflowID ?>">Edit</a></td>    
    
    <?}?>
    
    <td class="<?= $tdButtonClass ?>">&nbsp;</td>
     
    <td class="<?= $tdButtonClass ?>"><a href="popupSVG.php?mode=totalPlan&workflowID=<?= $workflowID ?>">Visualise</a>&nbsp;</td>

    <td class="<?= $tdButtonClass ?>"><a href="advancedVisualiseWorkflow.php?workflowID=<?= $workflowID ?>">Visualise+</a>&nbsp;</td>
    
<?}




/**
 * @return void
 * @param Array $data
 * @param String $style
 * @desc Displays the HTML table head
*/
function dataTableHead($data, $style, $title){

	$tableClass = 'sofT';
	$tdClass = 'helpHed';

	
	?>
<table width="98%" class="<?= $tableClass ?>"><tr><td colspan="<?= sizeof($data)+4 ?>" class="<?= $tdClass ?>main"><?= $title ?></td></tr>
<tr>

	<td class="<?= $tdClass ?>" width="40">
		JobId
	</td>

<? for($index=0; $index < sizeof($data); $index++){ ?>	
	
	<td class="<?= $tdClass ?>" width="100">
		<?= $data[$index] ?>
	</td>

	
<?}?>
	
	
</tr>	
<? }


//Archive
function archiveTableHead($data, $style, $title){

	$tableClass = 'sofT';
	$tdClass = 'helpHed';

	
	?>
<table width="98%" class="<?= $tableClass ?>"><tr><td colspan="<?= sizeof($data)+4 ?>" class="<?= $tdClass ?>main"><?= $title ?></td></tr>
<tr>

	<td class="<?= $tdClass ?>" width="40">
		JobId
	</td>

<? for($index=0; $index < sizeof($data); $index++){ ?>	
	
	<td class="<?= $tdClass ?>" width="100">
		<?= $data[$index] ?>
	</td>

	
<?}?>
	<td width="100" class="<?= $tdClass ?>" >Creation Date</td>	
	<td class="<?= $tdClass ?>" colspan="2">&nbsp;</td>

	
</tr>	
<? }



	
/**
 * @return void
 * @param Array $data
 * @param String $style
 * @desc Displays the HTML table head
*/
function tableHead($data, $style, $title){
	
	$tableClass = 'sofT';
	$tdClass = 'helpHed';

	?>
<table width="98%" class="<?= $tableClass ?>"><tr><td colspan="<?= sizeof($data)+8 ?>" class="<?= $tdClass ?>main" ><?= $title ?></td></tr>
<tr>

	<td class="<?= $tdClass ?>" width="40">
		JobId
	</td>

<? for($index=0; $index < sizeof($data); $index++){ ?>	
	
	<td  class="<?= $tdClass ?>" width="100">
		<?= $data[$index] ?>
	</td>

<?}?>

	<td class="<?= $tdClass ?>" >Current Form</td>
	<td class="<?= $tdClass ?>" >Workflow creator</td>
	<td class="<?= $tdClass ?>" >Creation date</td>
	
	<td colspan="4" class="<?= $tdClass ?>" >&nbsp;</td>
	
		
</tr>
	
<? }


/**
 * @return void
 * @desc Displays the HTML for closing a table
*/
function tableMainClose(){?>


	</table>

<?}

/**
 * @return void
 * @desc Displays the HTML for opening a table
*/
function tableMainOpen(){
	$tableClass = 'sofT';
	
	?>



<table class="<?=$tableClass?>" width="100%"><tr>
	
<? }

/**
 * @return void
 * @param String $data
 * @desc Displays the HTML for a table cell
*/
function tableCell($data){ 
	
	$tdClass = 'helpHed';
	
	?>

	<td class="<?= $tdClass ?>" ><?= $data ?></td>	
	
<? }

}
?>