<?php
   
	 require_once('../includes/library/core/xml.php');
	 require_once('../includes/library/messaging/errors.php');
	 require_once('../includes/library/messaging/debug.php');
    
	 class TestOfXMLToArray extends UnitTestCase {
        
	    function TestOfXMLToArray() {
            $this->UnitTestCase();
        }
        
        function testXMLToArrayOpen() {
        
        	$xml = new XMLtoArray("");
        	$this->assertError( $xml->openXML());
        	        	
        	$xml = new XMLtoArray("unknown.xml");
        	$this->assertError( $xml->openXML());
        	
        	$xml2 = new XMLtoArray("jobSpecification.xml");
        	$this->assertNoErrors($xml2->directory = "../specifications/xml/");
        	        	
        }
        
        function testXMLProcessing(){
        	
        	$xml = new XMLtoArray("jobSpecification.xml");
        	$this->assertNoErrors($xml->directory = "../specifications/xml/");
        	
        	$xmldata = 	'<?xml version="1.0" encoding="UTF-8"?>';
       	
        	$this->assertNotNull($xml->process());
        	$this->assertNotNull($xml->stackSize());
      	
        	
        }
        
                   
    }
?>