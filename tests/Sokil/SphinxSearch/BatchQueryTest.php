<?php

namespace Sokil\SphinxSearch;

class BatchQueryTest extends \PHPUnit_Framework_TestCase
{
    private $_queryFactory;
    
    public function setUp() {
        $this->_queryFactory = new QueryFactory('127.0.0.1', '23023');
    }
    
    public function testFetch()
    {
        $batchFind = $this->_queryFactory
            ->batchFind();
        
        $batchFind->query()->in('idx_posts_user_1');
        $batchFind->query()->in('idx_posts_user_2');
        
        $resultSet = $batchFind->fetch();
        
        foreach($resultSet as $result) {
            $this->assertTrue(in_array($result->getAttribute('user_id'), array(1,2)));
        }
    }
}