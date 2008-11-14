<? 
if($$key != 'new'){	
	// it's an existing record so pull the details from the db
	$row = dbs::selrecord('*',$table,$key . '=' . $$key,'0','1');
	
	//print_r($row);
	
}
?>

<table border="0" cellspacing="1" cellpadding="1" width="100%">
<tr>
	<td class="bodybold" colspan="2"><a href="<?= $pageref; ?>">Groups</a>
	<? 
	if($$key != 'new'){
		// this is not a new record
		echo " ~ " . string::up($row[$identifier]); 
	}
	?>

	</td>
</tr>

<? hr(2);
if (isset($mesg)){
	html_displaymesg($mesg,2); 
}
?>

</table>


<!-- EDIT FORM INPUTS BEGINS -->

<table border="0" cellspacing="<?= $cellspacing; ?>" cellpadding="<?= $cellpadding; ?>" width="<?= $width; ?>">
<form method="post" action="<?= $pageref; ?>" name="<?= $edit_formname ?>" >

<input type="hidden" name="groupmembers" value="<?= $row['members']; ?>">
<input type="hidden" name="process" value="<? if($mode == 'add'){ echo 'add';}else{ echo 'edit'; }?>">

<tr>
<td colspan="2" class="bodybold">GROUPS</td>
</tr>

<? hr(2); ?>

<!-- NAME -->

<tr>
<td class="formbold" width="550">

<? 	
echo 'NAME<br>';
$textdata = formdata::getdata_text_extra('name', 'name', $table, $row['name']); 
formdisplay::display_text_extra($textdata, 'default', '', '');

?>

</td>
</tr>

<? dotline(2); ?>


	

<tr>

<td class="formbold" width="550">
<?
echo 'Members<br>';

if(!empty($row['members'])){
 
	$all = getallmembers($row['groupid']);
	
	if(sizeof($all) && sizeof($allmembers)){
	
		$allmembers = array_diff( $all, $allmembers);
			
	}else{	
		$allmembers = $all;	
	}	
	
	if(sizeof($allmembers) != 0 ){
?>
		
<table cellspacing="0" cellpadding="4" border="1">
		
<?
		foreach($allmembers as $member){
?>
				
<tr>
<td><?= getfirstname($member)?> <?= getlastname($member) ?></td>
<td><i><?= getuserrole($member) ?></i></td>
</tr>
				
<?
		}
?>		

</table>

<?
	}else{
		echo 'NONE';	
	}
}else{
	echo 'NONE';	
}
?>

</td>
</tr>


<!-- BUTTONS -->

<? hr(2); ?>
<tr>
<td colspan="2">

<?
$btndata = formdata::getdata_btn("submit","submit",'Save',""); 
formdisplay::display_btn($btndata,'default'); 	
?>

</td>
</tr>

<? hr(2); ?>

</form>
</table>

<!-- FORM ENDS -->