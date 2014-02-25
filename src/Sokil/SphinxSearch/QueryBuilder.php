<?php

namespace Sokil\SphinxSearch;

class QueryBuilder
{       
    private $_sphinxClient;
    
    private $_index = array();
    
    private $_query = array();
    
    private $_matchMode;
    
    private $_sortMode;
    
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
        $this->_matchMode = $matchMode;
        $this->_sphinxClient->setMatchMode($matchMode);
        return $this;
    }
    
    public function sortByRelevance()
    {
        $this->_sortMode = SPH_SORT_RELEVANCE;
        $this->_sphinxClient->setSortMode($this->_sortMode);
        return $this;
    }
    
    public function sortByAttributeAscending($attribute)
    {
        $this->_sortMode = SPH_SORT_ATTR_ASC;
        $this->_sphinxClient->setSortMode($this->_sortMode, $attribute);
        return $this;
    }
    
    public function sortByAttributeDescending($attribute)
    {
        $this->_sortMode = SPH_SORT_ATTR_DESC;
        $this->_sphinxClient->setSortMode($this->_sortMode, $attribute);
        return $this;
    }
    
    public function sortByTimeSegments($attribute)
    {
        $this->_sortMode = SPH_SORT_TIME_SEGMENTS;
        $this->_sphinxClient->setSortMode($this->_sortMode, $attribute);
        return $this;
    }
    
    public function sort(array $list)
    {
        $this->_sortMode = SPH_SORT_EXTENDED;
        
        $query = array();
        foreach($list as $field => $direction) {
            $direction = ($direction === 1) ? 'ASC' : ' DESC';
            $query[] = $field . ' ' . $direction;
        }
        
        $this->_sphinxClient->setSortMode($this->_sortMode, implode(',', $query));
        return $this;
    }
    
    public function setFieldWeights(array $weights)
    {
        $this->_sphinxClient->setFieldWeights($weights);
        return $this;
    }
    
    public function whereAttribute($name, $value)
    {
        $this->_sphinxClient->setFilter($name, (array) $value);
        return $this;
    }
    
    public function exceptAttribute($name, $value)
    {
        $this->_sphinxClient->setFilter($name, (array) $value, true);
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
        if(!$this->_matchMode) {
            $this->setMatchMode(SPH_MATCH_EXTENDED2);
        }
        
        if(!$this->_sortMode) {
            $this->sortByRelevance();
        }
        
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