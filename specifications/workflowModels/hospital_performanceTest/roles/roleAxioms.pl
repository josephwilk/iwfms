:- multifile axiom/2.

/*------------------Users--------------------------------------------------*/

axiom(authenticatedForGroup(Group),[user(User), knowledgeBase(User,Group)]).


%Access levels  for groups

axiom(groupLevel(0, superuser),[]).

axiom(groupLevel(1, receptionist),[]).
axiom(groupLevel(1, receptionist1),[]).
axiom(groupLevel(1, receptionist2),[]).
axiom(groupLevel(1, receptionist3),[]).
axiom(groupLevel(1, receptionist4),[]).
axiom(groupLevel(1, receptionist5),[]).
axiom(groupLevel(1, receptionist6),[]).
axiom(groupLevel(1, receptionist7),[]).
axiom(groupLevel(1, receptionist8),[]).
axiom(groupLevel(1, receptionist9),[]).
axiom(groupLevel(1, receptionist10),[]).
axiom(groupLevel(1, receptionist11),[]).
axiom(groupLevel(1, receptionist12),[]).
axiom(groupLevel(1, receptionist13),[]).
axiom(groupLevel(1, receptionist14),[]).
axiom(groupLevel(1, receptionist15),[]).

axiom(groupLevel(2, doctor),[]).
axiom(groupLevel(3, pharmacist),[]).
axiom(groupLevel(4, nurse),[]).
axiom(groupLevel(5, staffNurse),[]).
