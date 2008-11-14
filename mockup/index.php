<?

include('../includes/config/database.php');
include('../includes/library/library_db_mysql.php');

function html_display($data,$workflowID){?>

	<table width="100%" border="1">
  	<tr> 
    	<td><?= $workflowID ?></td>
    <td>
 		<?   if($data['text1']){ echo 'true'; }else{echo 'false';}   ?>
    </td>
    <td>
    	<?   if($data['text2']){ echo 'true'; }else{echo 'false';}   ?>
    </td>
    <td><a href="form1.html">Edit</a></td>
    <td><em>1</em></td>
    <td><em>validated(form(form1, formElement( form(test1) ,value ) ))</em></td>
    <td><em>none</em></td>
  </tr>
<?}


function displayWorkflow($workflowID){
	
	$data['text1'] = dbs::selrecord('text1','text1', 'workflowid='.$workflowID ,0,3);
	$data['text2'] = dbs::selrecord('text2','text2', 'workflowid='.$workflowID ,0,3);
	
	html_display($data, $workflowID);
	
}
?>


<h2>Jobs in progress.</h2>
<table width="100%" border="1">
  <tr> 
    <td><strong>JobId</strong></td>
    <td><strong>Text1</strong></td>
    <td><strong>Text2</strong></td>
    <td><strong>Action</strong></td>
    <td><em>Timepoint (system info)</em></td>
    <td><em>Goal (system info)</em></td>
    <td><em>Pre-condtion (system info)</em></td>
  </tr>
 
  <tr> 
    <td>1</td>
    <td>
 <?   
 
    $result = dbs::selrecord('text1','text1', 'text1id=1' ,0,1);
    
    if($result){ echo 'true'; }else{echo 'false';}
    
    ?>
    
    
    </td>
    <td>false</td>
    <td><a href="form1.html">Edit</a></td>
    <td><em>1</em></td>
    <td><em>validated(form(form1, formElement( form(test1) ,value ) ))</em></td>
    <td><em>none</em></td>
  </tr>
  <tr> 
    <td>2</td>
    <td>true</td>
    <td>false</td>
    <td><a href="form2.html">Edit</a></td>
    <td><em>2</em></td>
    <td><em>validated(form(form2, formElement( form(test2) ,value ) ))</em></td>
    <td><em>validated(form(form1, formElement( form(test1) ,value ) ))</em></td>
  </tr>
</table>
<p>&nbsp;</p>
<h2>Completed Jobs.</h2>
<table width="54%" border="1">
  <tr> 
    <td width="34%"><strong>JobId</strong></td>
    <td width="38%"><strong>Text1</strong></td>
    <td width="28%"><strong>Text2</strong></td>
  </tr>
  <tr> 
    <td>3</td>
    <td>true</td>
    <td>true</td>
  </tr>
  <tr> 
    <td>4</td>
    <td>true</td>
    <td>true</td>
  </tr>
</table>
<p>&nbsp;</p>
<h3>Workflow units</h3>
<table width="75%" border="1">
  <tr> 
    <td width="19%">TextSubmission</td>
    <td width="47%">&nbsp;</td>
    <td width="34%">&nbsp;</td>
  </tr>
  <tr> 
    <td>CommentSubmission</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>