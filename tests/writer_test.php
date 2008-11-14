<?php
   
	 require_once('../includes/library/core/writer.php');
	 
	 
	 class TestOfWriter extends UnitTestCase{
        
	    function TestOfWriter() {
            $this->UnitTestCase();
        }
             
        function testWriterWritingInvalid(){
        
        	$this->assertFalse(writer::write('','',array()));
        	$this->assertFalse(writer::write('file','',array()));
        	$this->assertFalse(writer::write('file','dir',array()));
	       	$this->assertFalse(writer::write('','',array(1)));
        	           	
        }
        
        function testWriterWritingValid(){
        
        	$file = 'test';
			$dir = '../';        	
        	
        	$this->assertNoErrors(writer::write($file,$dir,array(1)));
        	$this->assertNoErrors(writer::write($file,$dir,array('x'=>1)));
        	           	
        }
       
        
    }
?>