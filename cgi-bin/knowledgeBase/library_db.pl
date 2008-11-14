:-ensure_loaded(library(bdb)).

/*
It is vital that with all attempts to open a database the common enviroment reference generated
from the string is passed. This ensures that when the PROLOG is running as CGI the different 
processes invoked from each CGI call refer to the same space.
Internally to each CGI process the enviroment reference is required as without it it will be able to
create the database files but not open them as databases.

The database and enviroment are created in the directory that the cgi-script invocation orientates.
eg.

http://iWFMS/prolog.cgi

The Enviroment and database would be orientated in the /iWFMS/folder

*/

db :: {
		
	%attributes
	trace(On) &
	enviromentName( 'iWFMS knowledge base' ) &
	
	% : implies this is a prolog terms
	test :-  :write('this is an object') &
	
	% :: implies a call to a local method
	test1 :- :: test &
	
	dbUpdate(Dbname, Specs, Data) :-
	
		% We want to ensure that no matter what happens in this query the enviroment 
		% and database are tidyed up
	
		:call_cleanup( db::dbUpdate_aux(Dbname,Specs,Data), 
		db::cleanup ) &
		
	%dbUpdate_aux('') :-
	%	trace(On),
	%	:write('Fatal Error: No data provided'),
	%	:fail &
					
	dbUpdate_aux(Dbname, Specs, Data) :-

		::enviromentName(EnvName),
		
		%Treat the clause as a PROLOG clause
		%:Dbname \= '',
		
		:db_open_env(EnvName,EnvRef),

		:db_open(Dbname, update, Specs,EnvRef, DBRefer),

		:db_store(DBRefer, Data, StoreRef),

		% Ensure database is updated
		:db_sync(DBRefer),
		
		% tidy up
		:db_close(DBRefer),
		:db_close_env(EnvRef) &

		
		
	dbDeleteAll( Dbname, Specs, PrimaryKeyPredicate ):-
		:call_cleanup( db::dbDeleteAll_aux(Dbname,Specs,PrimaryKeyPredicate), 
							  db::cleanup ) &
	
	dbDeleteAll_aux(Dbname, Specs, PrimaryKeyPredicate):-
		
		::enviromentName(EnvName),
		:db_open_env(EnvName,EnvRef),
		:db_open(Dbname, update, Specs,EnvRef, OpenDBRef),
		
		%findall references to PrimaryKeyPredicate and erase them
		:findall(PrimaryKeyPredicate, (db_fetch(OpenDBRef, PrimaryKeyPredicate,Ref), db_erase(OpenDBRef, Ref)), _),!,
			
		:db_close(OpenDBRef),
		:db_close_env(EnvRef) &
							  

	dbDelete(Dbname, Specs, PrimaryKeyPredicate):-	
		:call_cleanup( db::dbDelete_aux(Dbname,Specs,PrimaryKeyPredicate), 
							  db::cleanup ) &
		
	dbDelete_aux(Dbname, Specs, PrimaryKeyPredicate):-
	
		::enviromentName(EnvName),
		:db_open_env(EnvName,EnvRef),
		:db_open(Dbname, update, Specs,EnvRef, OpenDBRef),
	
		:db_fetch(OpenDBRef, PrimaryKeyPredicate, TermRef),!
		:db_erase(OpenDBRef, TermRef, PrimaryKeyPredicate),

		:db_sync(OpenDBRef),
		
		% tidy up
		:db_close(OpenDBRef),
		:db_close_env(EnvRef) &

	
	
	dbLookup(Dbname, Specs, PrimaryKeyPredicate):-
		:call_cleanup( db::dbLookup_aux(Dbname,Specs,PrimaryKeyPredicate), db::cleanup ) &
		
	dbLookup_aux(Dbname, Specs, PrimaryKeyPredicate):-

		::enviromentName(EnvName),
	
		:db_open_env(EnvName,EnvRef),
		:db_open(Dbname, read, Specs,EnvRef, OpenDBRef),

		% It is vital that the cut is used after this statement, as it has potential to rebound
		% with multiple values. Trying to close the database with more possible db_fetch options
		% causes a segementation fault
	
		:db_fetch(OpenDBRef, PrimaryKeyPredicate, ReadRef),!,

		:db_close(OpenDBRef),
		:db_close_env(EnvRef) &

	cleanup :-
		%:write('Clean Db'),:nl,
		:db_current(Dbname, Mode, SpecList ,EnvRef, DBRef),
		::close(EnvRef,DBRef,Iterator) &
	
	cleanup:-
		%:write('Clean Env'),:nl,
		:db_current_env(Envname, EnvRef),
		::close(EnvRef,DBRef,Iterator) &
	
	%cleanup must always succeed!
	cleanup &
				
	close(Env,Db, Iterator):-
		:ground(Env),
		\+ :(Env = 'none'),
		:db_close_env(Env) &
		
	close(Env,Db, Iterator):-
		:ground(Db),
		:db_close(Db)
	
		
}.