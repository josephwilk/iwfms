:- multifile axiom/2.
/*------------------------------- Assess Patient------------------------------------------------ */

axiom(happens(workflow(superReason,User), T1,T3),[
	
	happens(workflowNode(superReason,User),T1,T2),
	
	before(T1,T2),
	
	happens(workflowEdge(superReason,User),T3),
	
	before(T2, T3)
		
	
]).

axiom(happens(workflowNode(superReason, User),T1,T4),[
	
	%Locate group at level 2
	groupLevel(0, Group),
	user(User),

	happens(formEntry(superForm,User,Group),T1),
	
	before(T1,T2),
	
	not(clipped(T1,formEntered(superForm,User,Group),T2)),
	
	happens(formCreation(superForm, User),T2,T3),
	
	happens(formSubmission(superForm), T4),
	
	before(T3,T4)
				
]).

axiom(happens(workflowEdge(superReason,User), T1,T1),[
	holds_at( validated(form(superForm, formElement(  superID, relativeExpression, 'number') )), T1 )
]).