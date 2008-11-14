:-ensure_loaded('knowledgeBase/library_db.pl').
:-use_module(library(objects)).

prologUnit :: {

	addUser :-
		knowledgeBase :: addUser(Username,Forms,Groups),
		knowledgeBase :: lookupUser(Username) &
	
	deleteUser :-	
		knowledgeBase :: addUser(Username,Forms,Groups),
		knowledgeBase :: deleteUser(Username),
		\+ knowledgeBase :: lookupUser(Username) & 
		
	lookupUser :-	
		knowledgeBase :: lookupUser(Username) &	

	main:-
		addUser,
		deleteUser,
		lookupUser			
}