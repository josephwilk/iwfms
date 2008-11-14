:-ensure_loaded('planner/eventCalculusPlanner.pl').
:-ensure_loaded('configuration/debugControl.pl').
:- multifile axiom/2.


%no matter what Prolog finishes
main:- 
	call_cleanup( plan, finish).	

plan:-
	workflowModel(File),
	load_files(File),
	findall(R, plan([holds_at(goalNode,t)],R,100,1), Result), 
	write(Result).	
	