<?

include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$table = 'workflowModels';

?>
<form method="POST" action="createWorkflow.php">
<table border="0">
<tr>
<td width="20"><img src="images/wsb_side.gif" border="0"></td>
<td class="formbold" width="550">

Workflow Model:<br>
<?
$selectdata = formdata::getdata_select('modelId','description', '', $table, 0,0,0,0); 
formdisplay::display_select($selectdata,'default');
?>
</td>
</tr>

<tr>
<td></td>
<td>
<br><br>
<?

$submitButton = formdata::getdata_btn('submit','submit','Add workflow item','');
formdisplay::display_btn($submitButton,'default');

?>
</td></tr></form>
</form>
</table>
<?

include_once("includes/commonPages/system_footer.php"); ?>
