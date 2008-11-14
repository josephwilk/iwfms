:- multifile axiom/2.

axiom(happens(formInput(admissionForm),T1, T4),[
	
	%Findout what wards and the associted constraints with that ward
	wardInformation(WARD, AGE),

	happens(entry(admissionForm, houseNumber, presence, none), T1),
	happens(entry(admissionForm, road, presence, none), T2),
	before(T1,T2),
	
	happens(entry(admissionForm, age, function , AGE), T3),
	before(T2,T3),
	
	happens(entry(admissionForm, ward, match, WARD), T4),
	before(T3,T4)	
	
]).