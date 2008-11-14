:- multifile axiom/2.

/*----------------------------------- controlledDrugAuthorise-----------------------------------------*/

axiom(happens(workflow(controlledDrugAuthorise,User), T1,T3),[
	happens(workflowNode(controlledDrugAuthorise,User),T1,T2),
	before(T1,T2),
	
	happens(workflowEdge(controlledDrugAuthorise,User),T3),
	before(T2,T3)
	
]).


axiom(happens(workflowNode(controlledDrugAuthorise,User),T1,T5),[
	
	groupLevel( 5, Group),
	user(User),

	happens(formEntry(checkControlledDrug,User,Group),T1),
	
	%	not(clipped(T1,formEntered(checkControlledDrug,User,Group),T2)),
	
	happens(databaseFetch(controlledDrugsSpec), T2),
	before(T1,T2),
		
	happens(formCreation(checkControlledDrug, User),T3, T4),
	before(T2,T3),
	
	
%	not(clipped(T2,formCreated(checkControlledDrug),T3)),
		
	happens(formSubmission(checkControlledDrug), T5),
	before(T4,T5)
	
				
]).

axiom(happens(workflowEdge(controlledDrugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkControlledDrug, formElement( correctControlledDrug, match, false))) , T1 )
]).

axiom(happens(workflowEdge(controlledDrugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkControlledDrug, formElement( correctControlledDrug, match, true))) , T1 )
]).