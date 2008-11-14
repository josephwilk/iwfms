<?php
   
	 require_once('../includes/library/core/dbs.php');
	 require_once('../includes/configuration/database.php');
	 
	 class TestOfDatabase extends UnitTestCase {
        
	    function TestOfDatabase() {
            $this->UnitTestCase();
        }
                
        function testDatabaseOpen(){
        
        	$db = connect('');	
        	$this->assertFalse($db);
        	        	
        	$db = connect('iWFMS');	
        	$this->assertNotNull($db);
        	        	
        }
        
        function testDatabaseSelect() {
           
        	$db = connect('iWFMS');
        	$result = dbs::selrecord('*','users',0,0,1);
        	
        	$this->assertNotNull($result);
               		
        }
        
        function testDatabaseInsertDelete(){
        
        	$this->assertFalse(dbs::irrecord('',array(), false));
        	$this->assertFalse(dbs::irrecord('table',array(), false));
        	    	
        }
        
    }
?>