:- multifile valid_html_form/2.
:- multifile attributetype/3.

:- use_module(library(lists)).


:- ensure_loaded('contextFreeGrammarParser.pl').
:- ensure_loaded('currentHTMLdef.pl').



:- prolog_flag(toplevel_print_options,_,[quoted(true),numbervars(true),portrayed(true)]).

%Ensure rules included are added rather than overwritten.


%High level calls
% correctAssType(form1, test1, value ):-
	% Does this element have a custom type assocaited with it?
	% If so process it.
	% Find the relevant form, element and thus contructall type.
	% Check that the value is type correct

	
	
%Example call: valid_html_formChildren( select , [option] ).
	

convertChildrenToString([],[]).
convertChildrenToString( [Head|Tail], Accumulator) :-
	
	%Convert atom to character string
	atom_codes(Head, String),
	
	append(String,InputString, Accumulator),
	
	convertChildrenToString(Tail, InputString).


% Validates the children
valid_html_formChildren(select, Children ):-
	childrentyping(select, Type),

	convertChildrenToString(Children, ChildrenString),
	
	dtdValidator(Type, ChildrenString).
			

%Validates the attributes of HTML form elements
%Example call: valid_html_form(textbox, [size=2]),

valid_html_form(Element, List) :-	
	attributeList(List, Element, _, []),!.
	
valid_html_form(Element, List) :-	write('HTML Typing is incorrect for Element:&nbsp;&nbsp;'), write(Element), write('&nbsp;&nbsp;with &nbsp;&nbsp;Attributes: '),write(List), halt.
	
attributetype(E,A,V):- write('HTML Typing is incorrect <br>&nbsp;<i>attribute:'), write(A), write('&nbsp;&nbsp;value:'),write(V), write('</i><br>&nbsp;in html tag '),write(E), halt.