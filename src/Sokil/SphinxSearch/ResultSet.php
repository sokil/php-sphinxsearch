<?php

namespace Sokil\SphinxSearch;

class ResultSet implements \Iterator, \Countable
{
    private $_result;
    
    private $_matches;
    
    public function __construct(array $result) 
    {
        $this->_result = $result;
        
        $this->_matches = isset($this->_matches) 
            ? $this->_result['matches']
            : array();
    }
    
    public function rewind()
    {
        reset($this->_matches);
        return $this;
    }
    
    public function key()
    {
        return key($this->_matches);
    }
    
    public function valid()
    {
        return isset($this->_matches[$this->key()]);
    }
    
    public function next()
    {
        next($this->_matches);
        return $this;
    }
    
    public function current()
    {
        $current = current($this->_matches);
        if($current) {
            return new ResultItem($current);
        }
        else {
            return null;
        }
    }
    
    public function count()
    {
        return (int) $this->_result['total'];
    }
    
    public function toArray()
    {
        return $this->_result;
    }
}