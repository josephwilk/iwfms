<?

/* class htmlfunctions {{{ */
/**
 * Functions for outputting HTML
 * @author		Joseph Wilk 
 * @copyright	(c) 2004
 * @package htmlfunctions
 */
/* }}} */

class htmlfunctions{

function html_timestamp($datetime){

	$result = time::splitts($datetime);
	echo $result['date'];
	nbsp(2);
	echo '<span class="small">'. $result['time'] . '</span>';

}

function html_displaymesg($mesg,$colspan){	
	if($mesg){
?>
	
<tr>
<td align="center" colspan="<?= $colspan ?>" class="mesg"><? echo $mesg; ?></td>
</tr>

<?
		hr($colspan);
	}
}


function dotline($colspan){
?>	

<tr>
<td colspan="<?= $colspan ?>"><img src="images/spacer.gif" border="0" width="1" height="3"></td>
</tr>

<?	
}


function simplehr(){
?>
<hr size="1">
<?	
}





function hr($colspan){
?>

<tr>
<td colspan="<?= $colspan ?>" align="center"><hr size="1"></td>
</tr>

<?	
}


function br($number){
	// add no breaking spaces
	for($count=0; $count < $number; $count++){	
		echo '<br>';		
	}	
}


function nbsp($number){
	// add no breaking spaces
	for($count=0; $count <= $number; $count++){	
		echo '&nbsp;';		
	}	
}

}