:- multifile axiom/2.

/*----------------------------------- drugAuthorise-----------------------------------------*/

axiom(happens(workflow(drugAuthorise,User), T1,T3),[
	happens(workflowNode(drugAuthorise,User),T1,T2),
	before(T1,T2),
	
	happens(workflowEdge(drugAuthorise,User),T3),
	before(T2,T3)
	
]).


axiom(happens(workflowNode(drugAuthorise,User),T1,T5),[
	

	groupLevel(3,Group),
	user(User),

	happens(formEntry(checkdrugs,User,Group),T1),
	
	before(T1,T2),
	not(clipped(T1,formEntered(checkdrugs,User,Group),T2)),
	
	before(T2,T3),
	happens(formCreation(checkdrugs, User),T2, T3),
	
	before(T3,T4),
	
	happens(databaseFetch(drugsSpec), T4),
	
	before(T4,T5),
	
	not(clipped(T2,formCreated(checkdrugs),T5)),
		
	% Not needed as the actions generated from revoling formsubmission will achive these 
	% happens(formInput, T3),
	
	happens(formSubmission(checkdrugs), T5)
	
				
]).

axiom(happens(workflowEdge(drugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkdrugs, formElement( correctDrugs, match, false))) , T1 )
]).


axiom(happens(workflowEdge(drugAuthorise,User),T1, T1),[
	holds_at( validated(form(checkdrugs, formElement( correctDrugs, match, true))) , T1 )
]).