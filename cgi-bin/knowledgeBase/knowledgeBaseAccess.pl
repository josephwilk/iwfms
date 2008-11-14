:- include('knowledgeBase.pl').

add :- knowledgeDb :: addUser('jw99',forms,groups),halt.
lookup :- knowledgeDb :: lookupUser('jw99'), halt.