<?php

namespace Sokil\SphinxSearch;

class BatchQuery extends AbstractQuery
{    
    private $_queries = array();
    
    /**
     * Create new query
     * @return \Sokil\SphinxSearch\QueryBuilder
     */
    public function query()
    {
        $query = new QueryBuilder;
        $this->_queries[] = $query;
        
        return $query;
    }
    
    protected function _fetch()
    {
        /* @var $query \Sokil\SphinxSearch\QueryBuilder */
        foreach($this->_queries as $query) {
            $this->_sphinxClient->addQuery($query->getTextQuery(), $query->getIndexList(true));
        }
        
        return $this->_sphinxClient->runQueries();
    }
}