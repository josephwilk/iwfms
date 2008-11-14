:- multifile axiom/2.

/*-----------------------------------------------------------Planner requirements------------------------------------------------------------*/
abducible(dummy).
:- dynamic failure/2, executable/1.

executable(formEntry(_,_,_)).

executable(createFormElement(_,_,_,_,_)).

executable(formSubmission(_)).

executable(edgeProgression(_,_)).

executable(databaseFetch(_)).

executable(entry(_,_,_,_)).