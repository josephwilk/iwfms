<?php
   
	 require_once('../includes/library/xml/xmlDatabase.php');
	 require_once('../includes/library/xml/xmlDb.php');
	 require_once('../includes/library/xml/xmlField.php');
	 require_once('../includes/library/xml/xmlTable.php');
	 	 
	 require_once('../includes/library/xml/xmlPackage.php');
    
	 class TestOfXMLStructures extends UnitTestCase {
        
	    function TestOfXMLStructures() {
            $this->UnitTestCase();
        }
        
        function testxmlDatabaseSimple(){
        
        	$xmlDb = new xmlDb('');
        	$this->assertNoErrors($xmlDb->addTable(new xmlTable('')));

        	$this->assertEqual($xmlDb->getDisplayFields(),array());
        	
        	$this->assertEqual($xmlDb->getTables(), array(new xmlTable('')));
        	        	
        }


        function testxmlDatabaseReal(){
        
        	$xmlDb = new xmlDb('databasename');
        	
        	$xmlTable = new xmlTable('table');
        	
        	$xmlTable->addField(new xmlField('field','name'));
        	
        	$this->assertNoErrors($xmlDb->addTable($xmlTable));

        	$this->assertEqual($xmlDb->getDisplayFields(),array('name'));
        	
        	$this->assertEqual($xmlDb->getTables(), array($xmlTable));
        	        	
        }
        
               
    }
?>