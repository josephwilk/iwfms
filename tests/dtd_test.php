<?php
   
	require_once('XML_DTD/DTD.php')	 ;
	require_once('../includes/library/core/dtd.php');
	require_once('../includes/library/htmltyping/typeRule.php');
	require_once('../includes/library/prolog/dataStructures/prologPredicate.php');
	require_once('../includes/library/prolog/dataStructures/prologExpression.php');
	require_once('../includes/library/prolog/dataStructures/prologVar.php');
	require_once('../includes/library/prolog/dataStructures/prologAtom.php');
	require_once('../includes/library/prolog/dataStructures/prologRule.php');
	require_once('../includes/library/prolog/dataStructures/prologString.php');
	require_once('../includes/library/prolog/dataStructures/prologList.php');
	require_once('../includes/library/prolog/abstractConstructs/prologConstructCollection.php');

	
	class TestOfDTD extends UnitTestCase {
        
	    function TestOfDTD() {
            $this->UnitTestCase();
        }
        
        function testDTDFailure(){
        	
        	$this->assertFalse(dtd::findAttributes('',''));
        	$this->assertFalse(dtd::findAttributes('','file'));
        	$this->assertFalse(dtd::findAttributes('select',''));
        	$this->assertFalse(dtd::findAttributes('select','unknownFile.doc'));
        	$this->assertError(dtd::findAttributes('select','unknownFile.dtd'));
        	
        }        
        
        function testDTDSuccess(){
        	
        	$typeObject = dtd::findAttributes('select','../w3cDtds/xhtml1-strict.dtd');
        	$this->assertIsA($typeObject, 'typerule');

        	$this->assertNotNull($typeObject->regularExpressionPredicate);
        	$this->assertNotNull($typeObject->typename);
        	$this->assertNotNull($typeObject->ruleList);
        	$this->assertNotNull($typeObject->children);
        	$this->assertNotNull($typeObject->regularExpression);
        	
        	$this->assertNotEqual($typeObject->ruleList, array());
        	$this->assertNotEqual($typeObject->toArray(),array());
        	
        }	
                   
    }
?>