<?php
   
	 require_once('../includes/library/core/arrays.php');
    class TestOfArrays extends UnitTestCase {
        
	    function TestOfArrays() {
            $this->UnitTestCase();
        }
        
        function testArrayDelete() {
            
	        $array = new arrays();
	        $this->assertEqual($array->array_del(array(1,2,3),2), array(1,3));
	        $this->assertEqual($array->array_del(array(1),2), array(1));
	        $this->assertEqual($array->array_del(array(),2), array());
	        
        }
        
        function testArraySum() {
            
	        $array = new arrays();
	        $this->assertEqual($array->sum(array(1,2,3,2)), 8);
	        $this->assertEqual($array->sum(array()), 0);
	        
        }
        
        function testArrayExplode() {
            
	        $this->assertEqual(arrays::array_explode("",','), '');
	        $this->assertEqual(arrays::array_explode("string,string",','), array('string','string'));
	        $this->assertEqual(arrays::array_explode(",,",','), array('','',''));
	        
        }

        function testArrayChop(){
        
        	$this->sendMessage("test");
        	$this->assertEqual(arrays::array_chop(array(1,2,3),0), array(2,3));
                
    	}
    	
    	function testArrayForAll(){
    	
    		$this->assertTrue(arrays::forall(array(1,1,1)));	
    		$this->assertFalse(arrays::forall(array(1,0,1)));
    		$this->assertTrue(arrays::forall(array()));
    		
    	}
    	
    	function testArrayFindIndex(){
    	    
    		$this->assertEqual(arrays::findindex('c',array('c','d')), 0);
    		$this->assertFalse(arrays::findindex('d',array()));
    		$this->assertFalse(arrays::findindex('c',array('d')));
    		
    	}
    	
    	function testArrayMember(){
        
        	$this->sendMessage("test");
        	$this->assertTrue(arrays::member(1, array(1)));
        	$this->assertFalse(arrays::member(1, array()));
        	$this->assertFalse(arrays::member(1, array(2,3)));
                
    	}

		function testArraySearch(){
        
			$this->assertTrue(arrays::searchArray(array(1,2,3),array(1,5)));
			$this->assertTrue(arrays::searchArray(array(1,2,3),array(1)));
        	$this->assertFalse(arrays::searchArray(array(1,2,3),array()));
        	$this->assertFalse(arrays::searchArray(array(1,2,3),array(5)));
        	
    	}
    	    
        
    }
?>