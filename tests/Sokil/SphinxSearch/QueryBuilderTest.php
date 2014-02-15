<?php

namespace Sokil\SphinxSearch;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{  
    public function testFetch()
    {
        $qf = new QueryFactory('127.0.0.1', '23023');
        
        $resultSet = $qf->find()
            ->in('idx_posts')
            ->match('If you can')
            ->fetch();
        
        $this->assertInstanceOf('\Sokil\SphinxSearch\ResultSet', $resultSet);
        
        
        foreach($resultSet as $id => $resultItem) {
            $this->assertNotEmpty($id);
            $this->assertInstanceOf('\Sokil\SphinxSearch\ResultItem', $resultSet->current());
            $this->assertNotEmpty($resultItem->getWeight());
        }
    }
}