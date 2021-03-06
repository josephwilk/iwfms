<?php
    /**
     *	base include file for SimpleTest
     *	@package	SimpleTest
     *	@subpackage	WebTester
     *	@version	$Id: query_string.php,v 1.6 2004/03/17 20:32:36 lastcraft Exp $
     */
    
    /**
     * @ignore    Originally defined in simple_test.php
     */
    if (! defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', 'simpletest/');
    }
    
    /**
     *    Bundle of GET/POST parameters. Can include
     *    repeated parameters.
	 *    @package SimpleTest
	 *    @subpackage WebTester
     */
    class SimpleQueryString {
        var $_request;
        
        /**
         *    Starts empty.
         *    @param array $query/SimpleQueryString  Hash of parameters.
         *                                           Multiple values are
         *                                           as lists on a single key.
         *    @access public
         */
        function SimpleQueryString($query = false) {
            if (! $query) {
                $query = array();
            }
            $this->_request = array();
            $this->merge($query);
        }
        
        /**
         *    Adds a parameter to the query.
         *    @param string $key            Key to add value to.
         *    @param string/array $value    New data.
         *    @access public
         */
        function add($key, $value) {
            if (! isset($this->_request[$key])) {
                $this->_request[$key] = array();
            }
            if (is_array($value)) {
                foreach ($value as $item) {
                    $this->_request[$key][] = $item;
                }
            } else {
                $this->_request[$key][] = $value;
            }
        }
        
        /**
         *    Adds a set of parameters to this query.
         *    @param array $query/SimpleQueryString  Hash of parameters.
         *                                           Multiple values are
         *                                           as lists on a single key.
         *    @access public
         */
        function merge($query) {
            if (is_object($query)) {
                foreach ($query->getKeys() as $key) {
                    $this->add($key, $query->getValue($key));
                }
            } else {
                foreach ($query as $key => $value) {
                    $this->add($key, $value);
                }
            }
        }
        
        /**
         *    Accessor for single value.
         *    @return string/array    False if missing, string
         *                            if present and array if
         *                            multiple entries.
         *    @access public
         */
        function getValue($key) {
            if (! isset($this->_request[$key])) {
                return false;
            } elseif (count($this->_request[$key]) == 1) {
                return $this->_request[$key][0];
            } else {
                return $this->_request[$key];
            }
        }
        
        /**
         *    Accessor for key list.
         *    @return array        List of keys present.
         *    @access public
         */
        function getKeys() {
            return array_keys($this->_request);
        }
        
        /**
         *    Gets all parameters as structured hash. Repeated
         *    values are list values.
         *    @return array        Hash of keys and value sets.
         *    @access public
         */
        function getAll() {
            $values = array();
            foreach ($this->_request as $key => $value) {
                $values[$key] = (count($value) == 1 ? $value[0] : $value);
            }
            return $values;
        }
        
        /**
         *    Renders the query string as a URL encoded
         *    request part.
         *    @return string        Part of URL.
         *    @access public
         */
        function asString() {
            $statements = array();
            foreach ($this->_request as $key => $values) {
                foreach ($values as $value) {
                    $statements[] = "$key=" . urlencode($value);
                }
            }
            return implode('&', $statements);
        }
    }
?>