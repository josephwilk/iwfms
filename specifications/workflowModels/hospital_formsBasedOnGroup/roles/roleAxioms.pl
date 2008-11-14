:- multifile axiom/2.

/*------------------Users--------------------------------------------------*/

axiom(authenticatedForGroup(Group),[user(User), knowledgeBase(User,Group)]).

%axiom(user(joseph),[]).

%Access levels  for groups

axiom(groupLevel(0, superuser),[]).

axiom(groupLevel(1, receptionist),[]).
axiom(groupLevel(1, staffNurse),[]).

axiom(groupLevel(2, doctor),[]).

axiom(groupLevel(3, pharmacist),[]).

axiom(groupLevel(4, nurse),[]).

axiom(groupLevel(5, staffNurse),[]).
axiom(groupLevel(5, wardNurse),[]).

