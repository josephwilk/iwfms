<? 
include_once('includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$workflowID = $_GET['workflowID'];

$graphPlanList = graphPlanDatabaseAccess::getPlanGraphList($workflowID);

echo '<ul>';

echo '<li>';
echo '<a href="popupSVG.php?mode=totalOrdering&workflowID='. $workflowID .'">All Temporal Orderings</a><br><br>';

echo '<li>';
echo '<a href="popupSVG.php?mode=totalPlan&workflowID='. $workflowID .'">All Plans </a><br><br>';
echo '</ul><hr noshade><ul>';

echo '<table cellpadding="7" class="sofT" border="0">';
?>

<tr>
	<td class="helpHed" >Plan</td>
	<td class="helpHed" colspan="3">Modes</td>
</tr>




<?


for($index=0;$index < sizeof($graphPlanList);$index++){	

	echo '<tr>';
	echo '<td class="helpBod">';
	
	echo $index;
	
	echo '</td>';
	echo '<td class="helpBod">';
	
	echo '<a href="popupSVG.php?plan='.$index.'&mode=singularPlan&workflowID='. $workflowID .'">Action Plan</a>';

	echo '</td>';
	echo '<td class="helpBod">';
	
	echo '<a href="popupSVG.php?plan='.$index.'&mode=singularOrdering&workflowID='. $workflowID .'">Temporal Ordering</a>';

	echo '<td class="helpBod">';
	
	echo '<a href="popupSVG.php?plan='.$index.'&mode=multiOrdering&workflowID='. $workflowID .'">Plan And Temporal Ordering </a>';
	
	echo '</td>';
	echo '</tr>';
	
}

echo '</table>';

$time=false;

include_once("includes/commonPages/system_footer.php");

?>
