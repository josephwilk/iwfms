:- multifile axiom/2.


% ------------- Workflow Units ----------------------


:- ensure_loaded('workflowUnits/superReason.pl').
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


% -------------- edge progression axiom--------------------
:- ensure_loaded('progressions/progressions.pl').

%----------------------------------------------------------------


/* ---------------------------------------------Initial State Info--------------------------------------------------------------------------- */

%axiom(initially( neg( validated( form(assessForm, formElement(test2 ,value ) )))),[]).
%axiom(initially( neg( validated( form(admissionForm, formElement(test1 ,value) )) )),[]).