:- multifile axiom/2.
/*------------------------------- Assess Patient------------------------------------------------ */

axiom(happens(workflow(assessPatient,User), T1,T3),[
	
	happens(workflowNode(assessPatient,User),T1,T2),
	
	before(T1,T2),
	
	happens(workflowEdge(assessPatient,User),T3),
	
	before(T2, T3)
	
	
	
]).

axiom(happens(workflowNode(assessPatient, User),T1,T4),[
	

	%Locate group at level 2
	groupLevel(2, Group),
	user(User),

	happens(formEntry(assessForm,User,Group),T1),
	
	before(T1,T2),
	
	not(clipped(T1,formEntered(assessForm,User,Group),T2)),
	
	happens(formCreation(assessForm, User),T2,T3),
	
	happens(formSubmission(assessForm), T4),
	
	before(T3,T4)
				
]).

axiom(happens(workflowEdge(assessPatient,User), T1,T1),[
	holds_at( validated(form(assessForm, formElement( drugs, presence, none) )), T1 )
]).