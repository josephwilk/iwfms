:- multifile axiom/2.
/*------------------------------- Pharmacy ------------------------------------------------ */

axiom(happens(workflow(pharmacy,User), T1,T3),[
	
	happens(workflowNode(pharmacy,User),T1,T2),
	
	before(T1,T2),
	
	happens(workflowEdge(pharmacy,User),T3),
	
	before(T2, T3)
		
]).

axiom(happens(workflowNode(pharmacy, User),T1,T3),[
	

	groupLevel(3,Group),
	user(User),
	
	happens(formEntry(pharmacyForm,User,Group),T1),
	
	before(T1,T2),
	
	not(clipped(T1,formEntered(pharmacyForm,User,Group),T2)),
	
	happens(formCreation(pharmacyForm, User),T2),
	
	% happens(formInput, T3),
	
	before(T2,T3),
		
	happens(formSubmission(pharmacyForm), T3)
	
		
]).

axiom(happens(workflowEdge(pharmacy,User), T1,T1),[

	holds_at( validated(form(pharmacyForm,  formElement( pharmacyCollection ,match, true) )), T1 )

]).