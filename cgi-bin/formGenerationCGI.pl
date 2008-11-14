:- use_module(library(pillow)).
:- ensure_loaded('configuration/debugControl.pl').


main:- 
	call_cleanup( formGen, finish).	

	
formGen :- 
			%Findall HTML form elements to create
			
			findall(createFormElement(Type,Title, Name,Value,Att),createFormElement(Type,Title,Name,Value,Att),Terms),
			
			%convert predicates to HTML
			html2terms(HTML, Terms),
			
			%Output result
			pillow:write_string(HTML).
			
		