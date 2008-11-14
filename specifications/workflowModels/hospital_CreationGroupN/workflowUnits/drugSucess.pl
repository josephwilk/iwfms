:- multifile axiom/2.

% - drugSucess

axiom(happens(workflow(drugSucessPharmacy,User), T1,T3),[
	
	%Ensure that the user has not selected to loop
	notOccured(happens(edgeProgression(_, formElement(approvePharmacyChanges,match, false )),Tx,Tx)),

	happens(workflowNode(drugSucess,User),T1,T2),
	
	before(T1,T2),
	
	happens(workflowEdge(drugSucess,User),T3),
	before(T2,T3)

]).


axiom(happens(workflow(drugSucess,User), T1,T3),[
	
	notOccured(happens(edgeProgression(checkdrugs, formElement( correctDrugs ,match,  false )),Tx,Tx)),
	
	happens(workflowNode(drugSucess,User),T1,T2),
	
	before(T1,T2),
	
	happens(workflowEdge(drugSucess,User),T3),
	before(T2,T3)

]).


axiom(happens(workflowNode(drugSucess, User),T1,T3),[
	
	groupLevel( 3, Group),
	user(User),

	happens(formEntry(succedDrugAuthorise,User,Group),T1),
	
	before(T1,T2),
	not(clipped(T1,formEntered(succedDrugAuthorise,User,Group),T2)),
	
	happens(formCreation(succedDrugAuthorise, User),T2),
	
	before(T2,T3),
		
	happens(formSubmission(succedDrugAuthorise), T3)
			
]).


axiom(happens(workflowEdge(drugSucess,User), T1,T1),[
	holds_at( validated(form(succedDrugAuthorise, formElement( pharmacyTimescale, presence, none) )), T1 )
]).
