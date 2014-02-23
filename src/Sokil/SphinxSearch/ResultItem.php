<?php

namespace Sokil\SphinxSearch;

class ResultItem
{
    private $_resultItem;
    
    public function __construct(array $resultItem) {
        $this->_resultItem = $resultItem;
    }
    
    public function getWeight()
    {
        return $this->_resultItem['weight'];
    }
    
    public function getAttributes()
    {
        return $this->_resultItem['attrs'];
    }
    
    public function getAttribute($name)
    {
        return isset($this->_resultItem['attrs'][$name])
            ? $this->_resultItem['attrs'][$name]
            : null;
    }
    
    public function toArray()
    {
        return $this->_resultItem;
    }
}