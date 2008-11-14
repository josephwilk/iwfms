<?php
   
	 require_once('../includes/library/core/string.php');
    class TestOfString extends UnitTestCase {
        
	    function TestOfString() {
            $this->UnitTestCase();
        }
        
        function testStringLow() {
            
        	$this->assertEqual(string::low("HOUSE"), 'house');
        	$this->assertEqual(string::low("house"), 'house');
        	$this->assertEqual(string::low(""), '');
        		        
        }
        
        function testStringCaps() {
                    	
        	$this->assertTrue(string::is_caps('CAPS'));
        	$this->assertFalse(string::is_caps('caps'));
        	        		        
        }
        
        function testStringCapital() {
                    	
        	$this->assertEqual(string::capital('c'),'C');
        	$this->assertEqual(string::capital('C'), 'C');
        	$this->assertEqual(string::capital(''), '');
        	        		        
        }
        
        function testStringMatch() {
                    	
        	$this->assertTrue(string::match('1','1', false));
        	$this->assertFalse(string::match('11','1', false));
        	$this->assertTrue(string::match('','', false));        		        
        	
        }
        
        function testStringLowerFirstChar() {
                    	
        	$this->assertEqual(string::lowFirstChar('CHAR'),'cHAR');
        	$this->assertEqual(string::lowFirstChar('char'),'char');
        	$this->assertEqual(string::lowFirstChar(''),'');
        	
        }
        
                        
    }
?>