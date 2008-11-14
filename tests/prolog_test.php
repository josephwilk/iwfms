<?php

	require_once('../includes/library/prolog/dataStructures/prologPredicate.php');
	require_once('../includes/library/prolog/dataStructures/prologExpression.php');
	require_once('../includes/library/prolog/dataStructures/prologVar.php');
	require_once('../includes/library/prolog/dataStructures/prologAtom.php');
	require_once('../includes/library/prolog/dataStructures/prologRule.php');
	require_once('../includes/library/prolog/dataStructures/prologString.php');
	require_once('../includes/library/prolog/dataStructures/prologList.php');
	require_once('../includes/library/prolog/abstractConstructs/prologConstructCollection.php');
 
	 
	 class TestOfProlog extends UnitTestCase{
        
	    function TestOfProlog() {
            $this->UnitTestCase();
        }
            
        function testPrologAtomSimple(){
        	
        	$atom = new prologAtom("");
        	
        	$this->assertNotNull( $atom->atom );
        	$this->assertIsA($atom, 'prologAtom');
        	$this->assertEqual($atom->toString(), '');
        	$this->assertEqual($atom->type(), 'atom');
       	
        }
        
        function testPrologAtomReal(){
        	
        	$atom = new prologAtom("TestAtom");
        	
        	$this->assertNotNull($atom->atom);
        	$this->assertIsA($atom, 'prologAtom');
        	$this->assertEqual($atom->toString(), 'testAtom');
        	$this->assertEqual($atom->type(), 'atom');
        		
        	
        }
        
        
        

	    function testPrologStringSimple(){
        	
        	$string = new prologString("");
        	
        	$this->assertNotNull($string->string);
        	$this->assertIsA($string, 'prologString');
        	$this->assertEqual($string->toString(), "''");
        	$this->assertEqual($string->type(), 'string');
       	        	
        }

        function testPrologStringReal(){
        	
        	$string = new prologString("test string");
        	       	
        	$this->assertNotNull($string->string);
        	$this->assertIsA($string, 'prologString');
        	$this->assertNotEqual($string->toString(), "''");
        	$this->assertEqual($string->type(), 'string');
       	        	
        }
        
        function testPrologStringStrangeInput(){
        	
        	$string1 = new prologString("test'' string");
        	$string2 = new prologString("test// string");
        	$string3 = new prologString("test^&**(&*(_)+P{}:~@:<>?|ZX¬ string");
			$string4 = new prologString("test \" \" ''string");
        
        	      	
        	$this->assertNotNull($string1->string);
        	$this->assertIsA($string1, 'prologString');
        	$this->assertNotEqual($string1->toString(), "''");
        	$this->assertEqual($string1->type(), 'string');
       	    
        	$this->assertNotNull($string2->string);
        	$this->assertIsA($string2, 'prologString');
        	$this->assertNotEqual($string2->toString(), "''");
        	$this->assertEqual($string2->type(), 'string');
       	    
        	$this->assertNotNull($string3->string);
        	$this->assertIsA($string3, 'prologString');
        	$this->assertNotEqual($string3->toString(), "''");
        	$this->assertEqual($string3->type(), 'string');

			$this->assertNotNull($string4->string);
        	$this->assertIsA($string4, 'prologString');
        	$this->assertNotEqual($string4->toString(), "''");
        	$this->assertEqual($string4->type(), 'string');
       	    
        	  	    	
        }
        
        
        function testPrologListsSimpleChar(){
        	
        	$list = new prologList("");
        
        	$this->assertNotNull($list->listValues);
        	$this->assertIsA($list, 'prologList');
        	$this->assertEqual($list->toString(), '""');
        	$this->assertEqual($list->type(), 'list');
       	    
        	$this->assertTrue($list->charArray);
        	
        	        	
        }
        
        function testPrologListsSimpleList(){
        	
        	$list = new prologList("[]");
        
        	$this->assertNotNull($list->listValues);
        	$this->assertIsA($list, 'prologList');
        	$this->assertEqual($list->toString(), '[]');
        	$this->assertEqual($list->type(), 'list');
       	    
        	$this->assertFalse($list->charArray);
        	
        	        	
        }
        
        function testPrologListsRealCharArray(){
        	
        	$list = new prologList('character arrray');
        
        	$this->assertNotNull($list->listValues);
        	$this->assertTrue($list->charArray);
        	
        	$this->assertIsA($list, 'prologList');
        	$this->assertNotEqual($list->toString(), '""');
        	$this->assertEqual($list->type(), 'list');
       	            	        	
        }

        
        function testPrologListsRealList(){
        	
        	$list = new prologList('[character,arrray]');
        
        	$this->assertNotNull($list->listValues);
        	$this->assertFalse($list->charArray);
        	
        	$this->assertIsA($list, 'prologList');
        	$this->assertNotEqual($list->toString(), '""');
        	$this->assertEqual($list->type(), 'list');
        	
        	$values = $list->listValues;
        	
        	$this->assertIsA($values[0], 'prologAtom');
        	$this->assertIsA($values[1], 'prologAtom');
        
        	$this->assertEqual($values[0]->toString(), 'character');	
        	$this->assertEqual($values[1]->toString(), 'arrray');	
       	            	        	
        }
        
        function testPrologListsRealListComplex(){
        	
        	$list = new prologList('[character,[list,list2],predicate(test), "chararray"]');
        
        	$this->assertNotNull($list->listValues);
        	$this->assertFalse($list->charArray);
        	
        	$this->assertIsA($list, 'prologList');
        	$this->assertNotEqual($list->toString(), '""');
        	$this->assertEqual($list->type(), 'list');
        	
        	$values = $list->listValues;
        	
        	$this->assertIsA($values[0], 'prologAtom');
        	$this->assertIsA($values[1], 'prologList');
        	$this->assertIsA($values[2], 'prologPredicate');
        	$this->assertIsA($values[3], 'prologAtom');
        
        	$this->assertEqual($values[0]->toString(), 'character');	
        	$this->assertEqual($values[1]->toString(), '[list,list2]');	
        	$this->assertEqual($values[2]->toString(), 'predicate(test)');	
        	$this->assertEqual($values[3]->toString(), '"chararray"');	
       	            	        	
        }
        
        function testPrologVarSimple(){
        	
        	$var = new prologVar('');
        
        	$this->assertNotNull($var->varName);
        	$this->assertIsA($var, 'prologVar');
        	$this->assertEqual($var->toString(), '');
        	$this->assertEqual($var->type(), 'var');
       	            	        	
        }
        
        function testPrologVarReal(){
        	
        	$var = new prologVar('variable');
        
        	$this->assertNotNull($var->varName);
        	$this->assertIsA($var, 'prologVar');
        	$this->assertEqual($var->toString(), 'VARIABLE');
        	$this->assertEqual($var->type(), 'var');
       	            	        	
        }
        
		function testPrologVarUnusalInput(){
        	
        	$var = new prologVar('!"£$%^&*()_+\'');
        
        	$this->assertNotNull($var->varName);
        	$this->assertIsA($var, 'prologVar');
        	$this->assertEqual($var->toString(), '');
        	$this->assertEqual($var->type(), 'var');
       	            	        	
        }

        function testPrologExpression(){
        	
        	$exp1 = new prologExpression('','','');
        	$exp2 = new prologExpression('value','','');
        	$exp3 = new prologExpression('','value','');
        	$exp4 = new prologExpression('v1','v2','');
        	$exp5 = new prologExpression('','','equality');
        	
			$this->assertIsA($exp1, 'prologExpression');
        	$this->assertEqual($exp1->toString(), '');
        	$this->assertEqual($exp1->type(), 'expression');
			$this->assertNull($exp1->element1);


			$this->assertIsA($exp2, 'prologExpression');
        	$this->assertEqual($exp2->toString(), '');
        	$this->assertEqual($exp2->type(), 'expression');
			$this->assertNull($exp2->element1);
        	
			
			$this->assertIsA($exp3, 'prologExpression');
        	$this->assertEqual($exp3->toString(), '');
        	$this->assertEqual($exp3->type(), 'expression');
			$this->assertNull($exp3->element1);
        	
			
			$this->assertIsA($exp4, 'prologExpression');
        	$this->assertEqual($exp4->toString(), '');
        	$this->assertEqual($exp4->type(), 'expression');
			$this->assertNull($exp4->element1);
        				
			$this->assertIsA($exp5, 'prologExpression');
        	$this->assertEqual($exp5->toString(), '');
        	$this->assertEqual($exp5->type(), 'expression');
			$this->assertNull($exp5->element1);
        				 	
        }
                
        function testPrologExpressionReal(){
        	
        	$exp1 = new prologExpression(new prologAtom('t2'),new prologAtom('t3'),'equality');
        	$exp2 = new prologExpression(new prologList("chars"),new prologAtom("chars"),'equality');
        	$exp3 = new prologExpression(new prologPredicate("test(value)"),new prologPredicate("test(value)"),'equality');
        	$exp4 = new prologExpression(new prologVar("test"),new prologVar("test"),'equality');
        	
        	
			$this->assertIsA($exp1, 'prologExpression');
        	$this->assertEqual($exp1->toString(), 't2==t3');
        	$this->assertEqual($exp1->type(), 'expression');
       	            	       	
			$this->assertIsA($exp2, 'prologExpression');
        	$this->assertEqual($exp2->toString(), '"chars"==chars');
        	$this->assertEqual($exp2->type(), 'expression');

        	$this->assertIsA($exp3, 'prologExpression');
        	$this->assertEqual($exp3->toString(), 'test(value)==test(value)');
        	$this->assertEqual($exp3->type(), 'expression');

        	$this->assertIsA($exp4, 'prologExpression');
        	$this->assertEqual($exp4->toString(), 'TEST==TEST');
        	$this->assertEqual($exp4->type(), 'expression');

        	
        	
        }

        
        function testPrologPredicate(){
        
        	$pred = new prologPredicate("predicate(test,test2)");
        	
        	$this->assertIsA($pred, 'prologPredicate');
        	        	
        	$this->assertNotNull($pred->predicateValues);
        	$this->assertNotNull($pred->predicateName);
        	$this->assertEqual($pred->toString(), 'predicate(test,test2)');
        	$this->assertEqual($pred->type(), 'predicate');

        	$this->assertEqual($pred->getPredicateName(), 'predicate');
        	
        	$values = $pred->getPredicateValues();
        	
        	$this->assertIsA($values[0], 'prologAtom');
        	$this->assertIsA($values[1], 'prologAtom');
        	
        	$this->assertEqual($values[0]->toString(), 'test');
        	$this->assertEqual($values[1]->toString(), 'test2');
        	        	
        }
        
        
        
    }
?>