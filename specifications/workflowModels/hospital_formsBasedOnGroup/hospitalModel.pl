:- multifile axiom/2.


% ------------- Workflow Units ----------------------
:- ensure_loaded('workflowUnits/patientAdmission.pl').
:- ensure_loaded('workflowUnits/assessPatient.pl').

:- ensure_loaded('workflowUnits/drugAuthorise.pl').
:- ensure_loaded('workflowUnits/drugSucess.pl').
:- ensure_loaded('workflowUnits/drugFailure.pl').

:- ensure_loaded('workflowUnits/pharmacy.pl').

:- ensure_loaded('workflowUnits/controlledDrugAuthorise.pl').


% ------------------ Form creation ----------------------

:- ensure_loaded('forms/formCreation.pl').


% ------------------ Form Input ----------------------

:- ensure_loaded('userInput/formInput.pl').


% -------------------- Actions----------------------------

:- ensure_loaded('actions/highLevelActions.pl').


% ------------- Specific planner axiom----------------------
:- ensure_loaded('plannerRequirements/requirements.pl').


%---------------Hospital domain information---------------
:- ensure_loaded('hospitalDomainInformation/hospitalDomainInfo.pl').


% -------------- User Groups and Access rights------------
:- ensure_loaded('roles/roleAxioms.pl').


% -------------- User Groups and Access rights -----------
:- ensure_loaded('progressions/progressions.pl').

%-----------------------------------

%axiom(initiates( edgeLoop(admissionForm), neg( form(admissionForm, formElement(test1, value ) )), T),[]).
%axiom(terminates( edgeLoop(admissionForm), form(admissionForm, formElement( test1 ,value ) ), T),[]).

%axiom(initiates( edgeLoop(assessForm), neg( form(assessForm, formElement(test2 ,value ) )), T),[]).
%axiom(terminates( edgeLoop(assessForm), form(assessForm, formElement(test2,value )), T),[]).



/* ---------------------------------------------Initial State Info--------------------------------------------------------------------------- */

%axiom(initially( neg( validated( form(assessForm, formElement(test2 ,value ) )))),[]).
%axiom(initially( neg( validated( form(admissionForm, formElement(test1 ,value) )) )),[]).

/* -------------------------------------------------Models----------------------------------------------------------------------------------- */

% 
% formElement(FORM, ELEMENT_NAME, ELEMENT_VALUE to be valid)
% This format has the problem that it does not allow for portential sharing of formElements...
% By having the formid explicilty in the formElement my be limiting