<?php

namespace Sokil\SphinxSearch;

class QueryBuilder
{       
    private $_sphinxClient;
    
    private $_index;
    
    private $_query;
    
    public function __construct(array $options)
    {        
        $this->_sphinxClient = new \SphinxClient;
    }
    
    public function setServer($host, $port = \Sokil\SphinxSearch::DEFAULT_PORT)
    {
        $this->_sphinxClient->setServer($host, $port);
        return $this;
    }
    
    public function setMatchMode($matchMode)
    {
        $this->_sphinxClient->setMatchMode($matchMode);
        return $this;
    }
    
    public function setSortMode($sortMode)
    {
        $this->_sphinxClient->setSortMode($sortMode);
        return $this;
    }
    
    public function setFieldWeights(array $weights)
    {
        $this->_sphinxClient->setFieldWeights($weights);
        return $this;
    }
    
    public function whereAttribute($name, $value)
    {
        $this->_sphinxClient->setFilter($name, $value);
        return $this;
    }
    
    public function exceptAttribute($name, $value)
    {
        $this->_sphinxClient->setFilter($name, $value, true);
        return $this;
    }
    
    public function where($field, $value)
    {
        $this->_query[$field] = $value;
        return $this;
    }
    
    public function getTextQuery()
    {
        
    }
    
    public function __toString()
    {
        return $this->getTextQuery();
    }
    
    public function setLimit($offset, $limit)
    {
        $this->_sphinxClient->setLimits($offset, $limit, $limit);
        return $this;
    }
    
    public function fetch($index = null)
    {
        $query = $this->__toString();
        
        $result = $this->_sphinxClient->query($query, $index);
        if(!$result) {
            throw new \Exception('Error executing query');
        }
        
        return new ResultSet($result);
    }
}