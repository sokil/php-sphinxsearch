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
    
    public function testWhereAttribute()
    {
        $value = 2;
        
        $resultSet = $this->_queryFactory->find()
            ->match('if')
            ->whereAttribute('user_id', $value)
            ->fetch();
        
        $userIdList = $resultSet->getColumn('user_id');
        
        $this->assertEquals(
            $value * count($userIdList), 
            array_sum($userIdList),
            'Filter not working'
        );
    }
    
    public function testMultipleWhereAttribute()
    {        
        $resultSet = $this->_queryFactory->find()
            ->match('if')
            ->in('idx_comments')
            ->whereAttribute('user_id', 2)
            ->whereAttribute('post_id', 2)
            ->fetch();
        
        $this->assertEquals(2, $resultSet->current()->getAttribute('user_id'));
        
        $this->assertEquals(2, $resultSet->current()->getAttribute('post_id'));
    }
    
    public function testSort()
    {
        // get without sort
        $resultSet = $this->_queryFactory->find()
            ->match('if')
            ->in('idx_comments')
            ->sort(array(
                'user_id'   => -1,
                'post_id'   => -1,
            ))
            ->fetch();
        
        // get sorted
        $resultSetSorted = $this->_queryFactory->find()
            ->match('if')
            ->in('idx_comments')
            ->sort(array(
                'user_id'   => -1,
                'post_id'   => -1,
            ))
            ->fetch();
        
        $sortedUserId   = $resultSet->getColumn('user_id');
        arsort($sortedUserId);
        $this->assertEquals($resultSetSorted->getColumn('user_id'), $sortedUserId);
        
        $sortedPostId    = $resultSet->getColumn('post_id');
        arsort($sortedPostId);
        $this->assertEquals($resultSetSorted->getColumn('post_id'), $sortedPostId);
    }
}