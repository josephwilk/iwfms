<?
include_once( 'includes/configuration/core_configuration.php');
include_once("includes/commonPages/system_headerWC.php");

flush();

$model = dbs::selrecord('workflowCaching,location','workflowModels',"modelId=$modelId",0,4);
$cached = dbs::selrecord('plan','workflowcachingstore',"modelId=$modelId",0,2);

if(!$model['workflowCaching'] || $cached == ''){

	$hospitalMode = $model['location'];
	
	$mode = new prologPredicate('workflowModel',array(new prologString($hospitalMode)));
	
	performance::message("Start Prolog Planner");
	$filename = prolog::transferToProlog($_SESSION['valid_user'], array(":- multifile axiom/2.\n",$mode->toString().".\n", "axiom(user(".string::low($_SESSION['valid_user'])."),[])."));
	
	
	$plans = prolog::exec('planGenerationCGI.pl','main',$filename);
	
	//Keep this for the demo
	//$plans="[[[happens(formEntry(superForm,joseph,superuser),t54,t54),happens(edgeProgression(loop(formEntry(assessForm,_A,_B)),formElement(approvePharmacyChanges,match,false)),t100,t100),happens(createFormElement(radio,[82,101,106,101,99,116,32,80,104,97,114,109,97,99,121,32,67,104,97,110,103,101,115],approvePharmacyChanges,false,[]),t97,t97),happens(createFormElement(radio,[65,112,112,114,111,118,101,32,80,104,97,114,109,97,99,121,32,67,104,97,110,103,101,115],approvePharmacyChanges,true,[]),t96,t96),happens(formSubmission(failedDrugsApproval),t95,t95),happens(formEntry(admissionForm,joseph,receptionist),t18,t18),happens(databaseFetch(drugsFailure),t91,t91),happens(formEntry(failedDrugsApproval,joseph,doctor),t89,t89),happens(createFormElement(textbox,[80,97,116,105,101,110,116,32,78,97,109,101],patientName,'',[size=30]),t23,t23),happens(createFormElement(textbox,[72,111,117,115,101,32,78,117,109,98,101,114],houseNumber,'',[size=50]),t24,t24),happens(edgeProgression(checkdrugs,formElement(correction,presence,none)),t85,t85),happens(edgeProgression(checkdrugs,formElement(correctDrugs,match,false)),t84,t84),happens(createFormElement(radio,[82,101,106,101,99,116,32,100,114,117,103,115],correctDrugs,false,[]),t81,t81),happens(createFormElement(radio,[65,112,112,114,111,118,101,32,100,114,117,103,115],correctDrugs,true,[]),t80,t80),happens(createFormElement(textarea,[68,114,117,103,32,67,111,114,114,101,99,116,105,111,110,115],correction,'',[rows=20,cols=40]),t79,t79),happens(edgeProgression(superForm,formElement(nameee,presence,none)),t78,t78),happens(formSubmission(checkdrugs),t75,t75),happens(databaseFetch(drugsSpec),t73,t73),happens(createFormElement(textbox,[82,111,97,100],road,'',[disabled,size=50]),t25,t25),happens(formEntry(checkdrugs,joseph,pharmacist),t67,t67),happens(createFormElement(textbox,[65,103,101],age,'',[disabled,size=50]),t26,t26),happens(createFormElement(select,[87,97,114,100],ward,'',[size=1]),t27,t27),happens(edgeProgression(assessForm,formElement(drugs,presence,none)),t63,t63),happens(createFormElement(radio,[116,101,115,116,50],test2,false,[]),t60,t60),happens(createFormElement(radio,[116,101,115,116,49],test2,true,[]),t59,t59),happens(formSubmission(superForm),t58,t58),happens(createFormElement(option,[80,108,101,97,115,101,32,115,101,108,101,99,116,32,97,32,87,97,114,100],empty,'',[]),t28,t28),happens(createFormElement(textarea,[68,114,117,103,32,112,101,114,115,99,114,105,112,116,105,111,110],drugs,'',[rows=30,cols=30]),t53,t53),happens(formSubmission(assessForm),t52,t52),happens(createFormElement(option,[65,100,117,108,116,115,32,87,97,114,100],childrensWard,adultWard,[]),t29,t29),happens(formEntry(assessForm,joseph,doctor),t48,t48),happens(createFormElement(option,[67,104,105,108,100,114,101,110,115,32,87,97,114,100],adultWard,childrensWard,[]),t30,t30),happens(createFormElement(endSelect,'',ward,'',[]),t31,t31),happens(edgeProgression(admissionForm,formElement(ward,presence,none)),t44,t44),happens(edgeProgression(admissionForm,formElement(patientName,presence,none)),t43,t43),happens(entry(admissionForm,houseNumber,presence,none),t34,t34),happens(entry(admissionForm,road,presence,none),t35,t35),happens(entry(admissionForm,ward,match,childrensWard),t37,t37),happens(entry(admissionForm,age,function,lessThan(18)),t36,t36),happens(formSubmission(admissionForm),t22,t22)],[before(t100,t99),before(t99,t),before(t95,t99),before(t91,t96),before(t97,t95),before(t96,t97),before(t83,t89),before(t89,t91),before(t85,t84),before(t84,t83),before(t75,t83),before(t67,t79),before(t81,t73),before(t80,t81),before(t79,t80),before(t78,t77),before(t77,t14),before(t58,t77),before(t62,t67),before(t73,t75),before(t63,t62),before(t52,t62),before(t54,t59),before(t60,t58),before(t59,t60),before(t48,t53),before(t53,t52),before(t42,t48),before(t44,t43),before(t43,t42),before(t22,t42),before(t31,t34),before(t37,t22),before(t36,t37),before(t35,t36),before(t34,t35),before(t18,t23),before(t30,t31),before(t29,t30),before(t28,t29),before(t27,t28),before(t26,t27),before(t25,t26),before(t24,t25),before(t23,t24)]]]";
	
	$stoptime = time::stoptiming();
	
	performance::message("Stop Prolog Planner");
	
	flush();
	
	if($plans =='' || $plans == '[]'){// No plan generated
		
		echo '<br><br>';
		errors::errorMessage('No plans were generated!');
	
	}
	elseif(preg_match('/HTML Typing/', $plans) ){// Typing error detected!
	
		echo '<br><Br>';
		errors::errorMessage($plans);
		
	}
	else{
	
		performance::message("Start Prolog Planner parsing");
		
		//Preformance overhead lies here!
		$planGraphList = GraphConversion::convertStringPrologPlansToGraphs($plans);
		
		$workFlowvalues= array();
		
		$workFlowvalues['timestamp']= $modified = time::ts_unix_mysql(time::timestamp());
			
		//Create a new workflow item
		$keyinserted = dbs::irrecord('workflow',$workFlowvalues, false);
		
		//Link all plans to this workflow item
				
		$newstoptime =  time::stoptiming() - $stoptime;
		$stoptime =  time::stoptiming();
		
		
		performance::message("Stop Prolog Planner parsing");
		
		if($model['workflowCaching']){
			
			saveCachePlans($planGraphList, $keyinserted, $modelId);
			
		}
		else{
			
			savePlans($planGraphList, $keyinserted,true);
		}
				
		$newstoptime =time::stoptiming() -  $stoptime;
		performance::message("Database updating");
				
		echo '<br><Br>';
		
		systemMessages::message("Plan generation complete!");
		
		systemMessages::message("Number of plans:".sizeof($planGraphList));
		
	}
}
else{
	
	$workFlowvalues= array();
		
	$workFlowvalues['timestamp']= $modified = time::ts_unix_mysql(time::timestamp());
			
	//Create a new workflow item
	$keyinserted = dbs::irrecord('workflow',$workFlowvalues, false);
		
	$planGraphList = dbs::selrecord('plan','workflowcachingstore',"modelId=$modelId",0,3);
	
	savePlans($planGraphList,$keyinserted,false);
	
	echo '<br><Br>';
	
	systemMessages::message("Plan generation using caching feature complete!");
		
	systemMessages::message("Number of plans:".sizeof($planGraphList));
		
	
}

function savePlans($planGraphList,$workflowKey,$seralise){
	
	$planValues=array();
	
	$dbValues=array();
	
	for($index=0; $index< sizeof($planGraphList); $index++){
		
		if($seralise){
		
			$plan = addslashes(serialize($planGraphList[$index]));
		}
		else{
		
			$plan = addslashes($planGraphList[$index]);
			
		}
		
		$planValues['workflowid']=  $workflowKey;
		$planValues['plan'] = $plan;
		
		array_push($dbValues, $planValues);
		
		//dbs::irrecord('plans',$planValues, false);
	}
	
	dbs::irrecordArray('plans',$dbValues, false);
	
}


function saveCachePlans($planGraphList,$workflowKey, $modelId){
		
	$planValuesCollection=array();
	$planWorkflowValuesCollection=array();
		
	$planValues=array();
	$planWorkflowValues=array();
	
	for($index=0; $index< sizeof($planGraphList); $index++){
		
		$plan = addslashes(serialize($planGraphList[$index]));
				
		$planValues['modelId'] = $modelId;
		$planValues['plan'] = $plan;
		
		array_push($planValuesCollection, $planValues);
		
		//dbs::irrecord('workflowcachingstore',$planValues, false);
		
		$planWorkflowValues['workflowid']=  $workflowKey;
		$planWorkflowValues['plan'] = $plan;
				
		array_push($planWorkflowValuesCollection, $planWorkflowValues);
		
		//dbs::irrecord('plans',$planWorkflowValues, false);
		
	}
	dbs::irrecordArray('plans',$planWorkflowValuesCollection, false);
	dbs::irrecordArray('workflowcachingstore',$planValuesCollection, false);
}


include_once("includes/commonPages/system_footer.php"); ?>