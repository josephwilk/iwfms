:- use_module(library(objects)).
:- include('knowledgeBase/library_db.pl').

knowledgeDb :: {
	main :- :db_open_env('iWFMS knowledge base',EnvRef),
				:db_open('wanty',update, [userAccess(+,-), userGroup(+,-)],EnvRef, DBRefer),
				:db_store(DBRefer, userAccess('jw99',[form1,form2]), StoreRef),
				:db_sync(DBRefer),
				:db_close(DBRefer),
				:db_close_env(EnvRef) &
	
				
	look :-	:db_open_env('iWFMS knowledge base',EnvRef),
				:db_open('wanty',read, [userAccess(+,-), userGroup(+,-)],EnvRef, DBRefer),
				:db_fetch(DBRefer, userAccess('jw99',X), ReadRef),!,
				:write(X),
				:db_close(DBRefer),
				:db_close_env(EnvRef)
		 
}.

:- knowledgeDb :: main, knowledgeDb :: look, halt.