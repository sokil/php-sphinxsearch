<?php

namespace Sokil\SphinxSearch;

class ResultSet implements \Iterator, \Countable
{
    private $_result;
    
    public function __construct(array $result) {
        $this->_result = $result;
    }
    
    public function rewind()
    {
        reset($this->_result['matches']);
        return $this;
    }
    
    public function key()
    {
        return key($this->_result['matches']);
    }
    
    public function valid()
    {
        return isset($this->_result['matches'][$this->key()]);
    }
    
    public function next()
    {
        next($this->_result['matches']);
        return $this;
    }
    
    public function current()
    {
        return new ResultItem($this->_result['matches'][$this->key()]);
    }
    
    public function count()
    {
        return count($this->_result['matches']);
    }
    
    public function toArray()
    {
        return $this->_result;
    }
}