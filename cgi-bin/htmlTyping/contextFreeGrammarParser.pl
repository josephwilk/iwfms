% DTD
% ID - Unquie
% CDATA - Character data. Anything other than " is allowed - '\' Might also cause problems
% NMToken - <foo name="A.B_C:D"/> ... Allowable characters: 
%				letters, digits, period, dash, underscore, colon, combining characters, extenders

% DTDRegex -
% '+' : At least one or more
% '|'  : either / or
% '*'  : zero or more
% '?'  : zero or 1 occurrence

% #IMPLIED : The attribute does not have to be included
% #REQUIRED : The attribute value must be included in the element
% #FIXED value : The attribute value is fixed

%DTD Imported Names
% Number integer

% currently ignore all SCRIPT Imported types
%------------------------------------------------------------------------------------------------------%


/*

BNF definition of DTD typings


<reg> ::= "(" expression ")"

<expression> ::= tokenString "," expression

<expression> ::=  "(" disjunction ")" "," expression

<expression> ::=  "(" disjunction ")"

<expression> ::=   disjunction

<expression> ::= tokenString

<disjunction> ::=  tokenString "|" expression 

<tokenString> ::= variable arity | variable 

<variable> ::= string

<string> ::= chars
<arity> ::= "*"
<arity> ::= "+"
<arity> ::= "?"
*/


reg(R) --> "(", expression(R), ")".
reg(+(R)) --> "(", expression(R), ")", arrity(Y,+).
reg(?(R)) --> "(", expression(R), ")", arrity(Y,?).
reg(*(R)) --> "(", expression(R), ")", arrity(Y,*).


expression( R) -->  disjunction(R).

disjunction( or(X,Y) ) --> tokenString(X), "|", expression(Y).

expression( +(X)  ) --> tokenString(X), arrity(Y, +) . 
expression( ?(X)  ) --> tokenString(X), arrity(Y, ?) . 
expression( *(X)  ) --> tokenString(X), arrity(Y, *) . 

expression( X ) --> tokenString(X) . 

tokenString(X) --> [X], {\+ regToken(X)}.
tokenString(&(X, Y)) --> [X], tokenString(Y), { \+ regToken(X) }.

regToken("+").
regToken("*").
regToken("?").

arrity(Y, +) --> "+".
arrity(Y, *) --> "*".
arrity(Y, ?) --> "?".


dtdValidator(DtdReg, InputString) :-
	reg(PrologDtdReg,DtdReg, []),!,
%	trace,
	
	typeCheck(PrologDtdReg,InputString).


typeCheck(Reg, String):-

		% All Regulaur expressions are implictly asummed to begin at the start i.e '^'

		validateString(Reg,String,Remainder),!,
		
		% If a remainder exists then there has only been a partial matching of the order
		% This means that the String does not obey the typing of the Reg.
		% eg. ?(a) matching "aa", matches the a but leaves the a.
		% Partial matches imply partical type ordering conformance

		% If Remainder is returned as an unbound varaible, this implies
		% that the string was completely matched. The reason it is unbound
		% is that clauses such as * have to fail on an empty string input.
		% Otherwise they would infinitly looping trying to find more patterns.
		% Due to this required failure The remainder is unbound.
								
		Remainder = [].



% ---------Type checking through regular expression matching-----------------


validateString(or(X,Y), InputString, Remainder):-
	validateString(X, InputString, Remainder).

validateString(or(X,Y), InputString, Remainder):-
	validateString(Y, InputString, Remainder).
	
	
% 1 or more	+

validateString(+(X), [Head|Tail], NewRemainder):-
	validateString( X, [Head|Tail], Remainder ),
	
	
	validateString( *(X), Remainder, NewRemainder ),
	
	% *(X) may fail to resolve meaning NewRemainder will be unbound
	% But there may be tokens left in the input stream.
	
	( var(NewRemainder) -> 			%Indicates that *(X)   succeded due to the base case of none
			NewRemainder = Remainder
		;
		true
	),
	 !.
	
	
	
	
% 0 or more *

validateString(*(X), InputString, NewRemainder):-
	validateString(X, InputString, Remainder),
	
	validateString(*(X), Remainder, NewRemainder),
	
	( var(NewRemainder) ->
			NewRemainder = Remainder
		;
		true
	),!.
	
	
validateString(*(X), InputString, Remainder).	
		
% 0 or 1 ?
validateString(?(X), InputString, Remainder):-
	validateString(X, InputString, Remainder).
	
validateString(?(X), InputString, Remainder).



validateString(&(X,Y), [Head|Tail], []):-
	check(X,Head),
	check(Y,Tail).	

validateString( &(X,Y), [Head|Tail], Remainder):-
	check(X,Head),
	validateString(Y, Tail, Remainder).
		
	
% If we only have one character left in the input string, X must be a character
validateString(X, [Head], []):- 
	check(X,Head).
	
validateString(X, [Head|Tail], Tail):- 
	check(X,Head).	
	
check(Char1, Char2):-
	
	%Check only compares numberss
	number(Char1), 
	number(Char2),
	Char1 =:= Char2.
	

%----------------------- test unit--------------------------%

runtest:-	
(\+ testand1(false)),write('TEST AND 1- failure'),nl,
(\+ testand2(false)),write('TEST AND 2- failure'),nl,
testand(true),write('TEST AND 1- sucess'),nl,
testor(true),write('TEST OR 1-sucess'),nl,
(\+ testor(false)), write('TEST OR 1- failure').


testand1(false) :- validateString(&(106,&(111,101)),[106,111],Remainder).
testand2(false) :- validateString(&(106,&(111,101)),[106,111,106],Remainder).
testand(true) :- validateString(&(106,&(111,101)),[106,111,101],Remainder).
testor(true) :- validateString(or(106,112),[106,112],Remainder).
testor(false) :- validateString(or(106,112),[106,112],Remainder).
testplus :- validateString(+(or(&(111,&(110,101)),&(116,&(119,111)))),[111,110,101,111,110,101],[]).
