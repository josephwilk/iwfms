<?

// library includes


//Database librarys

include_once($root.'includes/library/core/dbs.php');
include_once($root.'includes/library/core/dbpear.php');


include_once($root.'includes/library/messaging/debug.php');
include_once($root.'includes/library/messaging/errors.php');
include_once($root.'includes/library/messaging/systemMessages.php');
include_once($root.'includes/library/messaging/performance.php');

include_once($root.'includes/library/core/javaScript.php');

include_once($root.'includes/library/core/xml.php');
include_once($root.'includes/library/core/dtd.php');




include_once($root.'includes/library/core/groups.php');

// File Librarys
include_once($root.'includes/library/core/writer.php');

//Prolog librarys
include_once($root.'includes/library/Prolog/prolog.php');

include_once($root.'includes/library/Prolog/dataStructures/prologAtom.php');

//Core Prolog data structures
include_once($root.'includes/library/Prolog/dataStructures/prologVar.php');
include_once($root.'includes/library/Prolog/dataStructures/prologString.php');
include_once($root.'includes/library/Prolog/dataStructures/prologPredicate.php');
include_once($root.'includes/library/Prolog/dataStructures/prologList.php');


//Abstract Prolog data structurs
include_once($root.'includes/library/Prolog/abstractDataStructures/prologHappensPredicate.php');
include_once($root.'includes/library/Prolog/abstractDataStructures/prologBeforePredicate.php');


//Complex Prolog structures
include_once($root.'includes/library/Prolog/dataStructures/prologRule.php');
include_once($root.'includes/library/Prolog/dataStructures/prologContextFreeGrammarRule.php');
include_once($root.'includes/library/Prolog/dataStructures/prologExpression.php');

//Abstract prolog collections
include_once($root.'includes/library/Prolog/abstractConstructs/prologConstructCollection.php');
include_once($root.'includes/library/Prolog/abstractConstructs/prologPlanCollection.php');
include_once($root.'includes/library/Prolog/abstractConstructs/prologOrderingCollection.php');
include_once($root.'includes/library/Prolog/abstractConstructs/prologPlanCollection.php');

//Directed graph
include_once($root.'includes/library/directedGraph/edge.php');
include_once($root.'includes/library/directedGraph/node.php');
include_once($root.'includes/library/directedGraph/graph.php');

//Planning

include_once($root.'includes/library/plan/graphPlanDatabaseAccess.php');
include_once($root.'includes/library/plan/GraphConversion.php');

include_once($root.'includes/library/plan/graphPlan.php');
include_once($root.'includes/library/plan/planComparison.php');
include_once($root.'includes/library/plan/actionPacket.php');

//JAVAscript

include_once($root.'includes/library/plan/javaScript/javaScriptCollection.php');
include_once($root.'includes/library/plan/javaScript/javaScriptConstraint.php');
include_once($root.'includes/library/plan/javaScript/planningJavaScript.php');




include_once($root.'includes/library/plan/planArchiving.php');

include_once($root.'includes/library/plan/executingPlan/planAction.php');
include_once($root.'includes/library/plan/executingPlan/planningAgent.php');




include_once($root.'includes/library/Prolog/prologConversion.php');
include_once($root.'includes/library/Prolog/prologtoPHP.php');


include_once($root.'includes/library/htmltyping/typeRule.php');


include_once($root.'includes/library/xml/xmlDb.php');
include_once($root.'includes/library/xml/xmlField.php');
include_once($root.'includes/library/xml/xmlTable.php');

include_once($root.'includes/library/xml/xmlPackage.php');
include_once($root.'includes/library/xml/xmlDatabase.php');

include_once($root.'includes/library/workflowDisplay/workflowDisplayHTML.php');
include_once($root.'includes/library/workflowDisplay/coreWorkflowDataPacket.php');



//Core librarys
include_once($root.'includes/library/core/string.php');
include_once($root.'includes/library/core/time.php');

include_once($root.'includes/library/core/arrays.php');
include_once($root.'includes/library/core/process.php');
include_once($root.'includes/library/core/security.php');




//form input classes
include_once($root.'includes/library/forminputs/input_data.php');
include_once($root.'includes/library/forminputs/input_display.php');
include_once($root.'includes/library/forminputs/input_style.php');
include_once($root.'includes/library/forminputs/input_specific.php');
include_once($root.'includes/library/htmlfunctions/htmlFunctions.php');

?>