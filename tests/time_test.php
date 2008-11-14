<?php
   
	 require_once('../includes/library/core/time.php');
	 
	 
	 class TestOfTime extends UnitTestCase{
        
	    function TestOfTime() {
            $this->UnitTestCase();
        }
             
        function testFormatTime(){
        
        	$this->assertWantedPattern('/[0123456789]/', time::timestamp());
			$this->assertWantedPattern('/[0123456789]/', time::mysqldate_stamp());
        	           	
        }
        
        function testTiming(){
        	
        	time::starttiming();
        	$this->assertNotNull(time::stoptiming());
        	$this->assertWantedPattern('/[0123456789]*/',time::stoptiming());
        	
        }
        
        
    }
?>