:- multifile axiom/2.

%----------------------------------------Hospital domain information ---------------------------%

axiom(wardInformation(childrensWard, Age),[ ageFacts( child, Age )]).
axiom(wardInformation(adultWard, Age),[ ageFacts( adult, Age )]).

axiom(ageFacts( child, lessThan(18) ),[]).
axiom(ageFacts( adult, greaterThanOrEqual(18) ),[]).
