<?header("Content-type: image/svg+xml"); 

include_once('includes/configuration/core_configuration.php');

$workflowID = $_GET['workflowID'];
$graphPlanList = graphPlanDatabaseAccess::getPlanGraphList($workflowID);

$xmlSVG="";

switch ($_GET['mode']){

	case 'singularPlan':
		
	$xmlSVG = $graphPlanList[$_GET['plan']]->toSVG();
	$currentNode = $graphPlanList[$_GET['plan']]->getCurrentNodeSVG();
	
	$xmlSVG = processActions($xmlSVG, $currentNode);
	
	break;
		
	case 'singularOrdering':
	$xmlSVG = $graphPlanList[$_GET['plan']]->toSVGTime();
	$currentNode = $graphPlanList[$_GET['plan']]->getCurrentTimepointSVG();
	
	$xmlSVG = processTimepoints($xmlSVG, $currentNode);
	
	break;
	
	case 'multiOrdering':
		
	$xmlSVG = $graphPlanList[$_GET['plan']]->toSVG();
	$currentNode = $graphPlanList[$_GET['plan']]->getCurrentNodeSVG();
	
	$xmlSVG = processActions($xmlSVG, $currentNode);
	
	$timePointSVG = $graphPlanList[$_GET['plan']]->toSVGTime();
	$currentNode = $graphPlanList[$_GET['plan']]->getCurrentTimepointSVG();
	
	$xmlSVG .= processTimepoints($timePointSVG, $currentNode);
	
	break;	
	
	case 'totalOrdering':
		
		$currentNodeList=array();
	
		for($index=0;$index < sizeof($graphPlanList);$index++){	
		
			$xmlSVG .= $graphPlanList[$index]->toSVGTime();
			array_push($currentNodeList, $graphPlanList[$index]->getCurrentTimepointSVG());
			
		}
		
		$xmlSVG = processTimepoints($xmlSVG, $currentNodeList);
		
		break;
	
	case 'totalPlan':
	
		$currentNodeList=array();
	
		for($index=0;$index < sizeof($graphPlanList);$index++){	
		
			array_push($currentNodeList, $graphPlanList[$index]->getCurrentNodeSVG());	
			
			$xmlSVG .= $graphPlanList[$index]->toSVG();

		}
		$xmlSVG = processActions($xmlSVG, $currentNodeList);
	
		break;
	
		
}

//There is a restiction on the size of the data that can be processed
//by graphviz. Due to this we simpilfy some of the node data

function processActions($xmlSVG, $currentNode){

	$xmlSVG = preg_replace("/'/","_",$xmlSVG);
	$xmlSVG = preg_replace("/[\d]*/","",$xmlSVG);
	$xmlSVG = preg_replace("/[_]+/","_",$xmlSVG);
	
	//Remove any duplicate edges
	$SVGArray = explode(";\n",$xmlSVG);
	$SVGArray = arrays::removeDuplicates($SVGArray);
	
	$xmlSVG = implode(";\n", $SVGArray);

	//Highlight the goalNode
	$xmlSVG .= "goalNode[color=\"black\",shape=circle,style=filled,fillcolor=\".7 .3 1.0\"] ;\n";

	
	
	if(is_array($currentNode)){
	
		for($index=0;$index < sizeof($currentNode); $index++){
			
				$xmlSVG .= $currentNode[$index]."[color=\"black\",style=filled,fillcolor=\"yellow\"] ;\n";
			
		}
	
	}
	else{
		
		//Highlight the CurrentNode
		$xmlSVG .= $currentNode."[color=\"black\",style=filled,fillcolor=\"yellow\"] ;\n";
		
	}

	
	
	//Highlight the CurrentNode


	return $xmlSVG;
	
}

function processTimepoints($xmlSVG, $currentNode){	
	
	//Highlight the goalNode
	$xmlSVG .= "t[color=\"black\",shape=circle,style=filled,fillcolor=\".7 .3 1.0\"] ;\n";

	if(is_array($currentNode)){
	
		for($index=0;$index < sizeof($currentNode); $index++){
			
			$xmlSVG .= $currentNode[$index]."[color=\"black\",style=filled,fillcolor=\"yellow\"] ;\n";			
			
		}
	
	}
	else{
		
		//Highlight the CurrentNode
		$xmlSVG .= $currentNode."[color=\"black\",style=filled,fillcolor=\"yellow\"] ;\n";
		
	}
		
	return $xmlSVG;
	
}


$obj = com_load("Wingraphviz.dot");

$xml =  $obj->ToSVG('digraph prof {
					size="9,9"; 
					ratio = fill; 
					node [style=filled];'
					.$xmlSVG.					
'}');
echo $xml;
?>
<!--
<embed  ID="SVGEmbed" NAME="SVGEmbed"
            src="default.svgz" 
            width="800" 
            height="800" 
            type="image/svg+xml"
            PLUGINSPAGE="http://www.adobe.com/svg/viewer/install/"          
            >
            -->