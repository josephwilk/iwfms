<?
include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_header.php");

$xml='';
$xmlSVG='';
if(isset($prologPlan)){
	
	$planGraphList = GraphConversion::convertStringPrologPlansToGraphs($prologPlan);

	for($index=0;$index < sizeof($planGraphList);$index++){	
	
		$xmlSVG .= $planGraphList[$index]->toSVG();

	}
	
	$obj = com_load("Wingraphviz.dot");

	$xml =  $obj->ToSVG('digraph prof {
					size="20,20"; 
					ratio = fill; 
					node [style=filled];'
					.$xmlSVG.'}');
	$xml = preg_replace('/LL/', '__', $xml);
}else
{
	$prologPlan='';
}

?>

<TABLE width="100%" cellpadding="3" cellspacing="3"  style="BORDER-COLLAPSE: collapse">
  <FORM action="prologPlansToGraphs.php" method="POST">
  <TBODY>
  <TR>
    <TD colSpan=2>
    	<INPUT type="submit" value="Render graph"> 
    	
    	<INPUT name="Rander" type="button" value="Render DOT language to SVG Viewer" onclick=
        "">    
    	
    	
    	<INPUT type="hidden" value="" name="processing"> 
    </TD></TR>
  <TR>
      <TD>Prolog event calculus plans</TD>
      <TD>SVG output(Read only) 
        </TD></TR>
  <TR>
    <TD><TEXTAREA name="prologPlan" rows=15 wrap=off cols=70 align="top"><?= $prologPlan ?></TEXTAREA> </TD>
    <TD><TEXTAREA name="txtXML" rows=15  readOnly wrap=off cols=70 align="top"><?= $xml ?></TEXTAREA> 
    </TD></TR>
    <TR align="center"> 
      <TD colSpan=2>SVG as Image Layout(Read only)</TD>
    </TR>
    <TR align="center"> 
      <TD colSpan=2>
			<embed  ID="SVGEmbed" NAME="SVGEmbed"
            src="default.svgz" 
            width="800" 
            height="800" 
            type="image/svg+xml"
            PLUGINSPAGE="http://www.adobe.com/svg/viewer/install/"          
            >
      
      
      </TD>
    </TR></TBODY></TABLE>
</BODY></HTML>
