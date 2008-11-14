:- use_module(library(objects)).
:- include('library_db.pl').
:- use_module(library(pillow)).

knowledgeDb :: {

	spec([userAccess(+,-), userGroup(+,-)]) &
	predicates([userAccess, userGroup]) &
		
	addUser(Username,Forms,Groups):-	
		spec(Spec),
		
		
		%:Data1 = userAccess(Username,Forms),
		%:Data2 = userGroup(Username,Groups),
		
		%db  :: dbDelete(Username, Spec, userAccess(Username,[form1,form2]))
		
			
		% We use the username to unqiuely identifiy a database
		db :: dbUpdate(Username, Spec, userAccess(Username,Groups)) &

	lookupUser(Username):-	
		spec(Spec),
		db :: dbLookup(Username, Spec, userAccess(Username,FormAccess)),
	    :write(FormAccess) &
	
	lookupUserProlog(Username, FormAccess):-	
		spec(Spec),
		db :: dbLookup(Username, Spec, userAccess(Username,FormAccess)) &
	   	    	
	deleteUser(Username):-
		spec(Spec),	
		db :: dbDelete(Username, Spec, userAccess(Username,X))&
		
	deleteAllUser(Username):-
		spec(Spec),	
		db :: dbDeleteAll(Username, Spec, userAccess(Username,X))
		
}.

