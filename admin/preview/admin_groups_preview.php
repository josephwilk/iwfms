<table border="0" cellspacing="<?= $cellspacing; ?>" cellpadding="<?= $cellpadding; ?>" width="<?= $width; ?>">
<tr>
<td class="bodybold" colspan="2">NAMEGROUPS ~ <a href="<?= $pageref; ?>?<?= $key; ?>=new&mode=add">ADDGROUP</a> ~ <a href="<?= $pageref; ?>?mode=all">VIEWALLGROUPS</a>	

</td>
</tr>

<? 

hr(2);
html_displaymesg($mesg,2);
?>

<tr>
<form name="go" method="post" action="<?= $pageref; ?>">
<input type="hidden" name="mode" value="preview">
<td colspan="2">

<table border="0" cellpadding="4" cellspacing="0" class="searcher" width="100%">
<tr>
<td colspan="2" class="title">GROUPPRE</td>
</tr>
<tr>
<td width="260">Group name</td>
<td>
<?
// get an a-Z type selection box
$selectdata = formdata::getdata_select('initial', 'initial', $initial, arrays::genlist('A','Z'), 0,0,'initial');
$selectdata = formdata::add_option($selectdata, $initial, 0, 'CHOOSE');
// and display it
formdisplay::display_select($selectdata,'default'); 
?>
</td>
</tr>
<tr>
<td>KEYQUERY</td>
<td><input type="text" name="keyword" value="<?= $keyword; ?>" style="width:100px"></td>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="SEARCH"></td>
</tr>
</table>

</td>
</form>
</tr>

<? 
// get the preview info

if($initial){
	$sql = "name LIKE '" . $initial . "%'";
}elseif($keyword){
	// if there's a keyword then use that
	$sql = "name LIKE '%" . $keyword . "%'";
}else{
	$sql = '0';
}

if(!isset($start)){
	// record number to start the query from
	$start = 0;
}
// limit the number of records returned
$end = 10;

if($mode == 'preview'){
	$check = dbs::selrecord('*',$table,$sql,'0','0');
	$count = dbs::numrecords($check);
	$result = dbs::selrecord('*',$table,$sql,'name ASC LIMIT ' . $start . ',' . $end,'0');
	$final = dbs::numrecords($result);
}else{
	$check = dbs::selrecord('*',$table,'0','0','0');
	$count = dbs::numrecords($check);
	$result = dbs::selrecord('*',$table,'0','name ASC LIMIT ' . $start . ',' . $end,'0');
	$final = dbs::numrecords($result);
}	
if($count > 0){
	hr(2);
	
?>
<tr>
<td class="bodybold">GROUPNAME</td><td class="bodybold" align="right">ACTIONS</td>
</tr>
<?
	while ($row = dbs::fetchrecord($result)){
		hr(2);
?>
<tr>
<td valign="top" class="bodybold" title="ID: <?= $row[$key]; ?>"><?= $row[$identifier] ?></td>
<td align="right" valign="top" class="body"><span class="edit"><a class="whitelink" href="<?= $pageref; ?>?<?= $key; ?>=<?= $row[$key] ?>&mode=edit">EDIT</a></span><br> 

<br><span class="delete"><a class="whitelink" href="<?= $pageref; ?>?<?= $key; ?>=<?= $row[$key] ?>&process=delete" OnClick="return confirm(' DELETEMESG;')">DELETES</a></span>


</td>

</tr>
<?
	}
}
?>
</table>

<table border="0" cellspacing="<?= $cellspacing; ?>" cellpadding="<?= $cellpadding; ?>" width="<?= $width; ?>">
<? 
hr(0);
?>
<tr>
<td>
<?
if($count > 0){
	$restext = $start +1; 
	$restext .= ' ' . TO . ' ';
	$restext .= $start + $final; 
	$restext .= ' ' . OF . ' '; 
	$restext .= $count . ' ' . RESULTS . ' ';
	$pages = ceil($count / 10);
	for($i=0;$i<$pages;$i++){
		$j = $i * 10;
		$restext .= '|<a href="' . $pageref . '?start=' . $j;
		if(isset($mode)){
			$restext .= '&mode=preview&initial=' . $initial . '&keyword=' . $keyword;
		}
		$restext .= '"> ';
		$restext .= $i + 1;
		$restext .= ' </a>';
	}
	$restext .= "|\n";
	echo $restext;
}else{
	echo '<span class="error">' . string::up(NO) . ' ' . RESULTS . '</span>';
}
?>
</td>
</tr>
<?
hr(0);
?>
</table>