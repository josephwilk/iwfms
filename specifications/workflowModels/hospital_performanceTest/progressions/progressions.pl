:- multifile axiom/2.

%--------------Lower level Actions----------------------

axiom(initiates( edgeProgression(admissionForm, formElement( patientName, presence, none ) ), 
		  validated(form(admissionForm, formElement( patientName ,presence, none ) ) ), T),[
	
	holds_at( validated(form(admissionForm,formElement(ward,presence,none))) , T )
	
		
]).

axiom(initiates( edgeProgression(admissionForm, formElement( ward, presence, none ) ), 
		  validated(form(admissionForm, formElement( ward ,presence, none ) ) ), T),[
		
]).

axiom(initiates( edgeProgression(assessForm, formElement( drugs ,presence, none )), 
		  validated(form(assessForm, formElement( drugs, presence, none) ) ), T),[

]).

axiom(initiates( edgeProgression(checkControlledDrug, formElement( controlledDrugs ,match, true ) ), 
		  validated(form(checkControlledDrug, formElement( correctControlledDrug, match, true) ) ), T),[
	
]).



axiom(initiates( edgeProgression(loop(formEntry(assessForm,_,_)), formElement( controlledDrugs ,match, false ) ), 
		  validated(form(checkControlledDrug, formElement( correctControlledDrug, match, false ) ) ), T),[
	

]).



axiom(initiates( edgeProgression(pharmacyForm, formElement( pharmacyForm ,presence, none ) ), 
		  validated(form(pharmacyForm, formElement( pharmacyForm ,presence, none) ) ), T),[
]).

axiom(initiates( edgeProgression(checkdrugs, formElement( correctDrugs ,match, true ) ), 
		  validated(form(checkdrugs, formElement( correctDrugs, match, true) ) ), T),[
]).


axiom(initiates( edgeProgression(checkdrugs, formElement( correctDrugs ,match, false ) ), 
		  validated(form(checkdrugs, formElement( correctDrugs, match, false ) ) ), T),[
		  
		  	holds_at( validated(form(checkdrugs,formElement(correction,presence, none))) , T )

]).


axiom(initiates( edgeProgression(checkdrugs, formElement( correction ,presence, none ) ), 
		  validated(form(checkdrugs, formElement( correction ,presence, none ) ) ), T),[

]).


axiom(initiates( edgeProgression(failedDrugsApproval, formElement( approvePharmacyChanges ,match, true )), 
		  validated(form(failedDrugsApproval, formElement( approvePharmacyChanges, match, true) ) ), T),[
	
]).


axiom(initiates( edgeProgression(loop(formEntry(assessForm,_,_)), formElement( approvePharmacyChanges ,match, false )), 
		  validated(form(failedDrugsApproval, formElement( approvePharmacyChanges, match, false) ) ), T),[
	
]).


axiom(initiates( edgeProgression(succedDrugAuthorise, formElement( pharmacyTimescale , presence, none )), 
		  validated(form(succedDrugAuthorise, formElement( pharmacyTimescale, presence, none) ) ), T),[

]).



%axiom(initiates( edgeProgression(succedDrugAuthorise, formElement( test2 ,presence, none )), 
%		  validated(form(succedDrugAuthorise, formElement( test2, value) ) ), T),[
%]).
