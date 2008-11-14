<?

include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$table = 'dtdFiles';

if(! isset($_POST['dtdFile'])){
	
	$_POST['dtdFile'] = false;
	
}

if($_POST['dtdFile']){

	include_once('parseHTMLdtd.php');
	
	generatePrologDTDtyping($_POST['dtdFile']);

	systemMessages::message('Typing generated successfully');
			
}



?>

<form method="POST" action="">
<table border="0">
<tr>
<td width="20"><img src="images/wsb_side.gif" border="0"></td>
<td class="formbold" width="550">W3C DTD file<br>

<?
$selectdata = formdata::getdata_select('dtdFile' , 'dtdFile', $_POST['dtdFile'], $table, 0,0,0,0); 
formdisplay::display_select($selectdata,'default');

echo '</td></tr>';
echo '<tr><td>&nbsp;</td><td><br><br>';

$submitButton = formdata::getdata_btn('submit','submit','change DTD','');
formdisplay::display_btn($submitButton,'default');

?>

</tr></td>
</form>
</table>
<?



include_once("includes/commonPages/system_footer.php"); ?>
