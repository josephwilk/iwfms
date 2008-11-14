<?php
   
	 require_once('../includes/library/directedGraph/graph.php');
	 require_once('../includes/library/directedGraph/node.php');
	 require_once('../includes/library/directedGraph/edge.php');
	 
	 
	 class TestOfGraph extends UnitTestCase{
        
	    function TestOfGraph() {
            $this->UnitTestCase();
        }
             

        function testEmptyGraph(){
        
        	$graph = new graph();
        	
        	$this->assertEqual($graph->getEdges(), array());
        	$this->assertEqual($graph->findNode(''),'');
        	$this->assertEqual($graph->toSVG(),'');
         	$this->assertEqual($graph->findConnections(''),'');
        	
        }
        
        function testGraphNodes(){
        
        	$graph = new graph();
        	
        	$graph->addNode(new node('name', 'data'));
        	
        	$this->assertEqual($graph->findNode(''),'');
        	$this->assertIsA($graph->findNode('name'), 'node');
        	
        	$this->assertEqual($graph->toSVG(),'');
         	$this->assertEqual($graph->findConnections(''),'');
        	
        }
        
        function testGraphEdges(){
        
        	$graph = new graph();
        	
        	$graph->addEdge( new edge('t1','t2') );
        	
        	$this->assertEqual($graph->findNode(''),'');
			$this->assertEqual($graph->findNode('t1'),'');
			$this->assertEqual($graph->findNode('t2'),'');
        	
        	
        	$this->assertNotNull($graph->edges);
        	$this->assertEqual($graph->toSVG(),'');
        	$this->assertNotEqual($graph->toSVGTime(),'');
         	$this->assertEqual($graph->findConnections(''),'');
         	$this->assertEqual($graph->getEdges(), array(new edge('t1','t2')));
        	
        }
        

        function testGraphFull(){
        
        	$graph = new graph();
        	
        	$graph->addEdge( new edge('t1','t2') );
        	$graph->addNode(new node('t1',array(new prologAtom('data1'))) );
        	$graph->addNode(new node('t2',array(new prologAtom('data2'))) );
        	
        	$this->assertEqual($graph->findNode(''),'');
        	$this->assertIsA($graph->findNode('t1'), 'node');
        	$this->assertIsA($graph->findNode('t2'), 'node');

        	$this->assertNotNull($graph->edges);
        	$this->assertNotEqual($graph->toSVG(),'');
        	$this->assertNotEqual($graph->toSVGTime(),'');
         	$this->assertEqual($graph->findConnections(''),'');
         	$this->assertEqual($graph->getEdges(), array(new edge('t1','t2')));
       	
        }

        function testGraphFull1(){
        
        	$graph = new graph();
        	
        	$graph->createEdges( array( new edge('t1','t2'),new edge('t2','t3')  ) );
        	
        	$node1= new node('t1',array(new prologAtom('data1')));
        	$node2= new node('t2',array(new prologAtom('data2')));
        	        	
        	$graph->addNode( $node1 );
        	$graph->addNode( $node2 );
        	
        	$this->assertEqual($graph->findNode(''),'');
        	$this->assertIsA($graph->findNode('t1'), 'node');
        	$this->assertIsA($graph->findNode('t2'), 'node');
			
        	$this->assertEqual($graph->findNode('t1'), $node1);
			$this->assertEqual($graph->findNode('t2'),$node2);
			
								 	
        	$this->assertNotNull($graph->edges);
        	$this->assertNotEqual($graph->toSVG(),'');
        	$this->assertNotEqual($graph->toSVGTime(),'');
         	$this->assertEqual($graph->findConnections(''),'');
         	
         	print_r($graph->getEdges());
         	
         	$this->assertEqual($graph->getEdges(), array( new edge('t1','t2'),new edge('t2','t3')  ) );

        }
        
        
        function testNodesSimple(){
        	
        	$node = new node('','');
        	        	
        	$this->assertEqual($node->getName(),$node->name );
        	$this->assertEqual($node->getData(),$node->data );
        	
        	$this->assertEqual(node::getNodeData($node), '');
        	
        }
        
        function testEdgesReal(){
        
        	$edge = new edge('t1','t2');	
        	
        	$this->assertEqual($edge->match('t1'), 't2');
        	
        	$this->assertFalse($edge->match('t'));
        	        	
        	$this->assertEqual($edge->matchReverse('t2'), 't1');
        	
        	$this->assertEqual($edge->toSVG(), array('t1','t2'));
        	
        	$this->assertEqual($edge->toSVGTime(),"t1 -> t2;\n");
        	       	
        }
        
        
        function testEdgesIdenticalNodes(){
        
        	$edge = new edge('t1','t1');	
        	
        	$this->assertEqual($edge->match('t1'), 't1');
        	
        	$this->assertFalse($edge->match('t'));
        	        	
        	$this->assertEqual($edge->matchReverse('t1'), 't1');
        	
        	$this->assertEqual($edge->toSVG(), array('t1','t1'));
        	
        	$this->assertEqual($edge->toSVGTime(),"t1 -> t1;\n");
        	       	
        }
                
        
    }
?>