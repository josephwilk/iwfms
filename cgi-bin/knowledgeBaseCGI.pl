:- include('knowledgeBase/knowledgeBase.pl').
:- ensure_loaded('configuration/debugControl.pl').

%KnowledgeBase CGI

%No matter what happens Prolog must always end!
addUser :- call_cleanup( addUser_Internal, finish).	
lookup :- call_cleanup(lookup_Internal, finish).	
delete :- call_cleanup(delete_Internal, finish).


addUserManual(User,Groups) :- 
	deleteall(User), 
	knowledgeDb :: addUser(User,forms,Groups), 
	finish.

	
addUser_Internal :-  get_post_value(User,Groups),
							deleteall(User), knowledgeDb :: addUser(User,forms,Groups).

						
lookup_Internal :- 
	get_post_value(User), 
	knowledgeDb :: lookupUser(User).

lookupGroup(User, Group) :-
	 knowledgeDb :: lookupUserProlog(User,Group).


delete_Internal :- 
	get_post_value(User),
	knowledgeDb :: deleteUser(User).

deleteall(User) :- 
	knowledgeDb :: deleteAllUser(User).
