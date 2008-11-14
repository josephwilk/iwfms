:- multifile axiom/2.
/*----------------------------------- patientAdmission-----------------------------------------*/

axiom(happens(workflow(patientAdmission,User), T1,T3),[
	
	happens(workflowNode(patientAdmission,User),T1,T2),
	before(T1,T2),
	
	happens(workflowEdge(patientAdmission,User),T3),
	before(T2,T3)
	
]).

axiom(happens(workflowNode(patientAdmission,User),T1,T4),[
	
	%Locate group at level 1
	groupLevel(1, Group),
	user(User),
	
	happens(formEntry(admissionForm,User,Group),T1),
	
	before(T1,T2),
	
	
	happens(formCreation(admissionForm, User),T2,T3),
	
	happens(formSubmission(admissionForm), T4),
	before(T3,T4)
				
]).


	
axiom(happens(workflowEdge(patientAdmission,User),T1, T1),[
	holds_at( validated(form(admissionForm,formElement( patientName ,presence, none ))) , T1 ) 
]).	    
