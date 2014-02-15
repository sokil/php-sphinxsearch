<?php

namespace Sokil;

class QueryFactory
{
    const DEFAULT_PORT = 9312;
    
    private $_host;
    
    private $_port;
    
    private $_matchMode = SPH_MATCH_EXTENDED2;
    
    private $_sortMode = SPH_SORT_RELEVANCE;
    
    public function __construct($host = '127.0.0.1', $port = self::DEFAULT_PORT) {
        $this->setServer($host, $port);
    }
    
    public function setServer($host, $port = self::DEFAULT_PORT)
    {
        $this->_host = $host;
        $this->_port = $port;
        
        return $this;
    }
    
    public function setMatchMode($matchMode)
    {
        $this->_matchMode = $matchMode;
        return $this;
    }
    
    public function setSortMode($sortMode)
    {
        $this->_sortMode  = $sortMode;
        return $this;
    }
    
    public function find()
    {
        $queryBuilder = new QueryBuilder;
        
        $queryBuilder
            ->setServer($this->_host, $this->_port)
            ->setMatchMode($this->_matchMode)
            ->setSortMode($this->_sortMode);
        
        return $queryBuilder;
    }
}