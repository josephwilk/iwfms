
function expressionsToString(expression, source){

	switch(expression){
		
		case '>=' :
			re = new RegExp(expression);
			var newstr = source.replace(re, " must be greater than or equal to ");
			break;

		case '<' :
			re = new RegExp(expression);
			var newstr = source.replace(re, " must be less than ");
			break;
	
						
		case "==" :
			re = new RegExp(expression);
			var newstr = source.replace(re, " must be equal to ");
			break;
	
			
	}
	
	if(newstr!=''){
		return newstr;		
	}
	else{
	
		return source;	
		
	}
}

function english(str){

	var ar = str.match(/([^.]+).([^.]+).([^.]+).([^\s.>=<]+)(.*)/);
	var strtr = (RegExp.$5);
	
	var englishString;		
	
	englishString = expressionsToString("==", strtr);
	englishString = expressionsToString(">=", englishString);
	englishString = expressionsToString("<", englishString);
	
	return englishString
	
}



function testPlans(verbrose){
	
	var planMatched;
	var matchingPath;
	
	planNotMatched=true;
	matchingPath= 0;
	
	//Keep trying other plans if this plan was not matched
	for(index=0; index < planCollection.length && planNotMatched ;index++){
	
		planMatched = true;
		
		//Check whether this plan holds
		for(planIndex=0; planIndex < planCollection[index].length; planIndex = planIndex+2){
				
			if(verbrose){
				alert(planCollection[index][planIndex]);
			}
			
			planMatched = planMatched && eval(planCollection[index][planIndex]);
			
			if(planIndex==0 && eval(planCollection[index][planIndex])){
			
				matchingPath = index;
				
			}
			
			planNotMatched = !(planMatched);
			
			if(verbrose){
				alert(planMatched);
			}
					
		}
	}
	
	if(planMatched == false){
	
		if(verbrose){
       		alert('If ' + planCollection[matchingPath][1] + english(planCollection[matchingPath][0]) + ' then ' + planCollection[matchingPath][3] + english(planCollection[matchingPath][2]) );
			//alert('None of the javaScript plans where found to match youre input');	
		}
		
	}
	
	return planMatched;
	
}

function memberPlanArray(value){
	
	var match;
	
	match = false;
	
	for(index=0; index < planCollection.length; index++){
	
			for(planIndex=0; (planIndex < planCollection[index].length) && (!match); planIndex = planIndex+2){
				
				if( planCollection[index][planIndex+1] == value){
				
					match=true;	
					
				}
					
		}
	}
	
	return match;
}
	




function checkTime(current){
	
	var search = false;
	
	for(index=0; (search==false)&& (index < timeline.length) ;index++){

		if( timeline[index] == current ){

			search=true;	
			
		}
		
	}
		
	if(index < timeline.length){//We dont want to process the last item
	
		//alert(timeline[index]);
		document.forms['iwfmsForm'].elements[timeline[index]].disabled = false;
		
	}
}




function validate(){
		
	for(index=0; index < timeline.length ;index++){
		
		if (document.forms['iwfmsForm'].elements[timeline[index]].value == ""   || document.forms['iwfmsForm'].elements[timeline[index]].disabled){

			alert('You have not completed the required form elements! Please fill in ' + timeline[index]);
			return false;
		
		}
							
	}
	
	return true;
}



function checkPlanTime(current){
	
	var planMatched;
	var currentPlanTimeIsNow;	
	var matchingPath;
	var limit;
	
	limit=false;
	
	
	planMatched=false;
	currentPlanTimeIsNow = false;
	
	
	if( memberPlanArray(current) ){
			
		//Keep trying other plans if this plan was not matched
		for(index=0; index < planCollection.length && !planMatched ;index++){
		
			planMatched = true;
			currentPlanTimeIsNow = false;
			
			//Check whether this plan holds
			for(planIndex=0; (planIndex < planCollection[index].length) && (!currentPlanTimeIsNow); planIndex = planIndex+2){
					
				//alert(planCollection[index][planIndex]);
				//alert(planCollection[index][planIndex+1]);
				
				//Skip testing an element of the plan if it has no value at all !
				if( document.forms['iwfmsForm'].elements[(planCollection[index][planIndex+1])].value !='' ){
					
//					alert(planCollection[index][planIndex]);
					
					planMatched = planMatched && eval(planCollection[index][planIndex]);
				
//					alert(planMatched);
					
				}
				
				if(planIndex==0 && eval(planCollection[index][planIndex])){
			
					matchingPath = index;
					limit = true;
				
				}
			
				
						
			}
		}
		
		if(planMatched == false && limit){
	
	       		alert('If ' + planCollection[matchingPath][1] + english(planCollection[matchingPath][0]) + ' then ' + planCollection[matchingPath][3] + english(planCollection[matchingPath][2]) );
				//alert('None of the javaScript plans where found to match youre input');	
					
		}
		
		return planMatched;
	}
			
}


