:- multifile axiom/2.
/*--------------------------------------------------------Form Creation------------------------------------------------------------------*/

%Note: You cannot have the same predicate created in different forms!

axiom( happens(formCreation(checkControlledDrug,User), T1,T2),[
		
	%createFormElement( FORM_ELEMENT, DISPLAY_NAME, FORM_ELEMENT_NAME,VALUE, [ATTRIBUTES] )
	
	valid_html_form( input, [] ),
	
	happens( createFormElement(radio,"controlled drugs acceptable", controlledDrugs, true, []),T1),
	
	valid_html_form( input, [] ),
	
	happens( createFormElement(radio,"controlled drugs unacceptable", controlledDrugs, false, []),T2),
	
	before(T1,T2)
	
]).


axiom( happens(formCreation(admissionForm,User), T1,T11),[
	
	valid_html_form( input, [size=30] ),
	happens( createFormElement( textbox,"Patient Name", patientName,'', [size=30]),T1),
		
	
	%IF a before condition occurs here the planner when it readds for some strange reason happens(formCreation(form1))
	%Will not match createFormelement(b11, textbox, [multline, numlines(4)] ) as already in the plan as it 
	%is at a different time point due to the resolution of the before clause.
	
	valid_html_form( input, [size=100] ),
	happens( createFormElement(textbox,"House Number", houseNumber, '',[size=50] ),T2),
	before(T1,T2),
	
	valid_html_form( input, [disabled,size=30] ),
	happens( createFormElement(textbox,"Road", road, '',[disabled,size=50] ),T3),
	before(T2,T3),
	
	valid_html_form( input, [disabled,size=30] ),
	happens( createFormElement(textbox,"Age", age,'', [disabled,size=50] ),T4),
	before(T3,T4),
	
	valid_html_form( select, [size=1] ),
	valid_html_formChildren( select, [option] ),
	happens( createFormElement(select,"Ward", ward, '', [size=1] ),T5),
	before(T4,T5),

	
	happens( createFormElement(option,"Please select a Ward", empty, '', [] ),T6),
	before(T5,T6),
	
	happens( createFormElement(option,"Adults Ward", childrensWard, 'adultWard', [] ),T7),
	before(T6,T7),
	
	happens( createFormElement(option,"Childrens Ward", adultWard, 'childrensWard', [] ),T8),
	before(T7,T8),
		
	happens( createFormElement(endSelect,'', ward, '', [] ),T9),
	before(T8,T9),

	
	happens(formInput(admissionForm),T10, T11),
	before(T9,T10)	
	
]).



axiom( happens(formCreation(assessForm,User), T1,T1),[
	
	valid_html_form( textarea, [rows=30,cols=30] ),
	happens( createFormElement(textarea, "Drug perscription", drugs, '', [rows=30,cols=30]), T1)
	
	
]).

axiom( happens(formCreation(pharmacyForm,User), T1,T1),[
	
	valid_html_form( checkbox, [] ),
	happens( createFormElement(checkbox, "Pharmacy drugs ready to collect", pharmacyCollection, 'true', []),T1)
	
]).


axiom( happens(formCreation(failedDrugsApproval,User), T1,T2),[

	valid_html_form( input, [type=radio] ),
	happens(createFormElement( radio, "Approve Pharmacy Changes", approvePharmacyChanges, 'true', []),T1),
	
	valid_html_form( input, [type=radio] ),
	happens(createFormElement( radio, "Reject Pharmacy Changes", approvePharmacyChanges, 'false', []),T2),
	before(T1,T2)
	
]).

axiom( happens(formCreation(succedDrugAuthorise,User), T1,T1),[
	
	valid_html_form( input, [size=10] ),
	happens( createFormElement(textbox,"Pharmacy timescale", pharmacyTimescale ,'',[size=10] ),T1)

]).



axiom( happens(formCreation(checkdrugs,User), T1,T3),[
	
	valid_html_form( textarea, [rows=20,cols=40] ),
	happens( createFormElement(textarea,"Drug Corrections",correction, '',[rows=20,cols=40] ),T1),
	
	valid_html_form( input, [] ),
	happens( createFormElement(radio,"Approve drugs",correctDrugs, true,[] ),T2),
	
	before(T1,T2),
	
	valid_html_form( input, [] ),
	happens( createFormElement(radio,"Reject drugs", correctDrugs, false,[] ),T3),
	
	before(T2,T3)
	
]).


	
/*	Value representing the content that is posted to the server on submition if the 
		relevant form element has been selected.
	
	This only applies to:
		1. RadioBtn
		2. Checkboxes
		3. Selects
				
	For other elements value represents the content that the form element starts withs
	
	%TEXTBOX
	%valid_html_form( textbox, [multiline, numlines(4)] ),
	happens( createFormElement(textbox, "Name", name, value, [multline, numlines(4)]),T1)
		
	%CHECKBOX
	happens( createFormElement(checkbox, "Name", name, value, [multline, numlines(4)]),T1)
	
	%RADIOBTN
	% There cannot ever be a singular radiobutton
	%Values can never be the same as the planner will fail due to duplicate predicates
	%The names must be the same for each of the radio buttons
	
	happens( createFormElement(radio, "Name", name, value, [multline, numlines(4)]),T1)
	happens( createFormElement(radio, "Name", name, value2, [multline, numlines(4)]),T1)
	
	%TEXTAREA
	happens( createFormElement(textarea, "Name", name, value2, [multline, numlines(4)]),T1)
	

	%SELECTBOX
	% The order of options withing the select is based on their temporal point
		
	valid_html_formChildren( select, [children] ),
	happens( createFormElement(select,"Name", name, value, '', [size=1] ),T5),
	happens( createFormElement(option,"Name",name,  value, '', [] ),T6),
	happens( createFormElement(endSelect,'', name, value, '', [] ),T9),
*/	