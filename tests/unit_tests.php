<?php
    // $Id: unit_tests.php,v 1.37 2004/03/23 00:41:18 lastcraft Exp $
    
    if (! defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', '../phpUnit/');
    }
    require_once(SIMPLE_TEST . 'unit_tester.php');
    require_once(SIMPLE_TEST . 'web_tester.php');
    require_once(SIMPLE_TEST . 'shell_tester.php');
    require_once(SIMPLE_TEST . 'reporter.php');
    require_once(SIMPLE_TEST . 'mock_objects.php');
    require_once(SIMPLE_TEST . 'extensions/pear_test_case.php');
    require_once(SIMPLE_TEST . 'extensions/phpunit_test_case.php');
    
    class UnitTests extends GroupTest {
        function UnitTests() {
            $this->GroupTest('Unit tests');
            $this->addTestFile('arrays_test.php');
            $this->addTestFile('strings_test.php');
            $this->addTestFile('xml_test.php');
            $this->addTestFile('dtd_test.php');
            $this->addTestFile('database_test.php');
            $this->addTestFile('time_test.php');
            $this->addTestFile('writer_test.php');
            $this->addTestFile('security_test.php');
            $this->addTestFile('prolog_test.php');
            $this->addTestFile('directedGraph_test.php');
            $this->addTestFile('xmlStructures_test.php');
      		           
        }
    }
    
    if (! defined('TEST_RUNNING')) {
        define('TEST_RUNNING', true);
        $test = &new UnitTests();
        if (SimpleReporter::inCli()) {
            exit ($test->run(new TextReporter()) ? 0 : 1);
        }
        $test->run(new HtmlReporter());
    }
?>