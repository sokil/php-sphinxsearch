<?php

namespace Sokil\SphinxSearch;

class QueryBuilder
{
    private $_index = array();
    
    private $_query = array();
    
    public function in($index)
    {
        if(is_array($index)) {
            $this->_index = array_merge($this->_index, $index);
        }
        else {
            $this->_index[] = $index;
        }
        
        return $this;
    }
    
    public function match($query)
    {
        $this->_query[] = $query;
        return $this;
    }
    
    public function getTextQuery()
    {
        return implode(' ', $this->_query);
    }
    
    public function getIndexList($string = false)
    {        
        if(!$this->_index) {
            return '*';
        }
        
        if($string) {
            return implode(',', $this->_index);
        }
        
        return $this->_index;
    }
    
    public function __toString()
    {
        return $this->getTextQuery();
    }
}