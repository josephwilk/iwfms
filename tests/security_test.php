<?php
   
	  require_once('../includes/library/core/dbs.php');
	 require_once('../includes/configuration/database.php');
	 require_once('../includes/library/core/security.php');
	 
	 	 
	 class TestOfSecurity extends UnitTestCase{
        
	    function TestOfSecurity() {
            $this->UnitTestCase();
        }
             
        function testSecurityLoginFailure(){
        
        	$this->assertFalse(security::authenticateLogin('', '',''));	
        	$this->assertFalse(security::authenticateLogin('login', '',''));	
        	$this->assertFalse(security::authenticateLogin('login', '',''));	           	
        	$this->assertFalse(security::authenticateLogin('login', 'test','wrongpassword'));	           	
        	$this->assertFalse(security::authenticateLogin('login', 'test',''));	           	
        	$this->assertFalse(security::authenticateLogin('login', '','wrongpassword'));	           	
        
        	
        		
        }
                
        function testSecurityLoginSuccess(){
        
        	$this->assertTrue(security::authenticateLogin('login', 'test','test'));	           	
        	
        }
        
        
        
    }
?>

