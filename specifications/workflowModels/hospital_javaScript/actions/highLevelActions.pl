:- multifile axiom/2.

%High level actions

axiom(initiates( workflow(patientAdmission, User), connectedNode(1), T),[
	groupLevel(0, Group),
	authenticatedForGroup([Group])
]).


axiom(initiates( workflow(assessPatient, User), connectedNode(2), T1),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(1), T1)
	
]).


%High level actions
axiom(initiates( workflow(drugAuthorise, User), connectedNode(3), T2),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(2), T2)
	
]).

%Achieved through node 3
axiom(initiates( workflow(drugSucess, User), connectedNode(5), T4),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(3), T4)
]).


%Achieved through node 4
axiom(initiates( workflow(drugSucessPharmacy, User), connectedNode(5), T4),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(4), T4)
]).


axiom(initiates( workflow(drugFailureGoal, User), goalNode, T3),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(3), T3)
]).


axiom(initiates( workflow(pharmacy, User), connectedNode(6), T3),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(5), T3)
]).


axiom(initiates( workflow(controlledDrugAuthorise, User), goalNode, T3),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(6), T3)
]).


% node 3 gives false
% This will be used when we are trying to link drugFailure progressing to drugSucess
axiom(initiates( workflow(drugFailure, User), connectedNode(4), T3),[
	groupLevel(0, Group),
	authenticatedForGroup([Group]),
	holds_at(connectedNode(3), T3)
]).