<?php

namespace Sokil\SphinxSearch;

class QueryBuilder
{       
    private $_sphinxClient;
    
    private $_index = array();
    
    private $_query = array();
    
    public function __construct()
    {        
        $this->_sphinxClient = new \SphinxClient;
    }
    
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
    
    public function match($query)
    {
        $this->_query[] = $query;
        return $this;
    }
    
    public function getTextQuery()
    {
        return implode(' ', $this->_query);
    }
    
    public function __toString()
    {
        return $this->getTextQuery();
    }
    
    public function setLimit($limit, $offset = 0)
    {
        $this->_sphinxClient->setLimits($offset, $limit, $limit + $offset);
        return $this;
    }
    
    public function getLastError()
    {
        return $this->_sphinxClient->getLastError();
    }
    
    public function fetch()
    {
        // index
        if($this->_index) {
            $index = implode(',', $this->_index);
        }
        else {
            $index = '*';
        }
        
        // execute query
        $result = $this->_sphinxClient->query($this->getTextQuery(), $index);
        if(!$result) {
            throw new \Exception('Error executing query: ' . $this->getLastError());
        }
        
        // generate iterator
        return new ResultSet($result);
    }
}