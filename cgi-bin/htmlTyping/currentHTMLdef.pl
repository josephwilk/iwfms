:-ensure_loaded('typedefinitions.pl').
	
%	Attributes ::=	(value | name=value)*	
 	
attributeList([], Element) --> []. 
attributeList([Attribute|TailList], Element) --> 
	checkAttribute(Attribute, Element),
	attributeList(TailList, Element).

checkAttribute(Name=Value,Element) --> [], { attributetype(Element,Name,Value) }.
checkAttribute(Value,Element) --> [], { attributetype(Element,Value, _) }.