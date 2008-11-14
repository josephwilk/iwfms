:- multifile axiom/2.


axiom(happens(workflow(drugFailure,User), T1,T3),[
	
	%This action cannot occur if the correct drugs path is true
	notOccured(happens(edgeProgression(checkdrugs, formElement( correctDrugs ,match,  true )),Tx,Tx)),
	
	happens(workflowNode(drugFailure,User),T1, T2),
	
	before(T1,T2),
	
	happens(workflowEdge(drugFailure,User),T3),
	before(T2,T3)

]).


axiom(happens(workflow(drugFailureGoal,User), T1,T3),[
	
	%This action cannot occur if the correct drugs path is true
	notOccured(happens(edgeProgression(checkdrugs, formElement( correctDrugs ,match,  true )),Tx,Tx)),
	
	happens(workflowNode(drugFailure,User),T1, T2),
	
	before(T1,T2),
	
	happens(workflowEdgeFail(drugFailure,User),T3),
	before(T2,T3)

]).








axiom(happens(workflowNode(drugFailure, User),T1,T5),[
	
	groupLevel( 2,Group),
	user(User),

	happens(formEntry(failedDrugsApproval,User,Group),T1),
	
	before(T1,T2),
	not(clipped(T1,formEntered(failedDrugsApproval,User,Group),T2)),
	
	happens(databaseFetch(drugsFailure), T2),
	
	before(T2,T3),
	happens(formCreation(failedDrugsApproval, User),T3, T4),
		
	happens(formSubmission(failedDrugsApproval), T5),
	before(T4,T5)
			
]).


axiom(happens(workflowEdgeFail(drugFailure,User), T1,T1),[
	holds_at( validated(form(failedDrugsApproval, formElement( approvePharmacyChanges ,match, false ) ) ), T1 )
]).



axiom(happens(workflowEdge(drugFailure,User), T1,T1),[
	holds_at( validated(form(failedDrugsApproval, formElement( approvePharmacyChanges ,match, true ) ) ), T1 )
]).


axiom(happens(workflowEdge(drugFailure,User), T1,T1),[
	holds_at( validated(form(failedDrugsApproval, formElement( approvePharmacyChanges ,match, false ) ) ), T1 )
]).
