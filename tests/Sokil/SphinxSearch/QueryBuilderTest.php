<?php

namespace Sokil\SphinxSearch;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $_queryFactory;
    
    public function setUp() {
        $this->_queryFactory = new QueryFactory('127.0.0.1', '23023');
    }
    
    public function testFetch()
    {        
        $resultSet = $this->_queryFactory->find()
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
    
    public function testFetchUnexisted()
    {
        $resultSet = $this->_queryFactory->find()
            ->in('idx_posts')
            ->match('unexisted_string')
            ->fetch();
        
        $this->assertInstanceOf('\Sokil\SphinxSearch\ResultSet', $resultSet);
        
        $this->assertEquals(0, count($resultSet));
        
        $this->assertEmpty($resultSet->current());
    }
    
    public function testLimit()
    {
        $limit = 3;
        $offset = 2;
        
        // get without limits
        $resultSet = $this->_queryFactory->find()
            ->match('if')
            ->fetch();
        
        $fullIdList = $resultSet->getDocumentIdList();
        
        // get limited
        // get without limits
        $resultSet = $this->_queryFactory->find()
            ->match('if')
            ->setLimit($limit, $offset)
            ->fetch();
        
        $this->assertEquals(
            array_slice($fullIdList, $offset, $limit),
            $resultSet->getDocumentIdList()
        );
    }
}