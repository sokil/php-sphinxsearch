<?php

namespace Sokil\SphinxSearch;

class QueryFactory
{
    const DEFAULT_PORT = 3312;
    
    private $_host;
    
    private $_port;
    
    public function __construct($host = '127.0.0.1', $port = self::DEFAULT_PORT) {
        $this->setServer($host, $port);
    }
    
    public function setServer($host, $port = self::DEFAULT_PORT)
    {
        $this->_host = $host;
        $this->_port = $port;
        
        return $this;
    }
    
    public function find()
    {
        $query = new SingleQuery;
        $query->setServer($this->_host, $this->_port);
        
        return $query;
    }
    
    public function batchFind()
    {
        $query = new BatchQuery;
        $query->setServer($this->_host, $this->_port);
        
        return $query;
    }
}