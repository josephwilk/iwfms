:- multifile axiom/2.

/*----------------------------------- controlledDrugAuthorise-----------------------------------------*/

axiom(happens(workflow(controlledDrugAuthorise,User), T1,T3),[
	happens(workflowNode(controlledDrugAuthorise,User),T1,T2),
	before(T1,T2),
	
	happens(workflowEdge(controlledDrugAuthorise,User),T3),
	before(T2,T3)
	
]).


axiom(happens(workflowNode(controlledDrugAuthorise,User),T1,T3),[
	
	groupLevel(4,Group),
	user(User),

	happens(formEntry(checkControlledDrugs,User,Group),T1),
	
	before(T1,T2),
	not(clipped(T1,formEntered(checkControlledDrugs,User,Group),T2)),
	
	happens(formCreation(checkControlledDrugs, User),T2),
	
	before(T2,T3),
	not(clipped(T2,formCreated(checkControlledDrugs),T3)),
		
	% Not needed as the actions generated from revoling formsubmission will achive these 
	% happens(formInput, T3),
	
	happens(formSubmission(checkControlledDrugs), T3)
	
				
]).

axiom(happens(workflowEdge(controlledDrugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkControlledDrugs,formElement(correctControlledDrugs,false))) , T1 )
]).

axiom(happens(workflowEdge(controlledDrugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkControlledDrugs,formElement(correctControlledDrugs,true))) , T1 )
]).