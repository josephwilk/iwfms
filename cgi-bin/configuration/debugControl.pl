:-use_module(library(lists)).


fileSource("C:/Program Files/Apache Group/Apache2/htdocs/iwfms/cgi-bin/transfer/").

ini(DataSource) :-
						    % information passed on the command line must use single quotes
						    % Characters and numbers cannot occur together in a double quote
							
							%convert to a character string 
							
							name(DataSource, Stringname),
							fileSource(X),
							append(X, Stringname, Result),
							
							%Convert character string to atom
							atom_codes(Atom, Result),
							
							%write(Atom),
							
							[Atom].

finish :- halt.