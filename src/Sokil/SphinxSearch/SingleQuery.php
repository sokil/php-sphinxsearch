<?php

namespace Sokil\SphinxSearch;

class SingleQuery extends AbstractQuery
{
    private $_queryBuilder;
    
    public function init() 
    {
        $this->_queryBuilder = new QueryBuilder;
    }
    
    public function __call($name, $arguments) {
        $result = call_user_func_array(array($this->_queryBuilder, $name), $arguments);
        if($result instanceof QueryBuilder) {
            return $this;
        }
        
        return $result;
    }
    
    protected function _fetch()
    {
        // execute query
        return $this->_sphinxClient->query($this->getTextQuery(), $this->getIndexList(true));
    }
}