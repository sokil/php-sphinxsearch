<?php

namespace Sokil\SphinxSearch;

class ResultSetTest extends \PHPUnit_Framework_TestCase
{
    public function testGetColumn()
    {
        $resultSet = new ResultSet(array(
            'matches'   => array(
                23 => array(
                    'weight'    => 1111,
                    'attrs'     => array(
                        'field' => 'a1',
                    )
                ),
                45 => array(
                    'weight'    => 1112,
                    'attrs'     => array(
                        'field' => 'a2',
                    )
                ),
                94 => array(
                    'weight'    => 1113,
                    'attrs'     => array(
                        'field' => 'a3',
                    )
                ),
            ),
        ));
        
        $this->assertEquals(array(23 => 'a1', 45 => 'a2', 94 => 'a3'), $resultSet->getColumn('field'));
    }
    
    public function testGetTotalCount()
    {
        $resultSet = new ResultSet(array(
            'matches'   => array(
                23 => array(
                    'weight'    => 1111,
                    'attrs'     => array(
                        'field' => 'a1',
                    )
                ),
                45 => array(
                    'weight'    => 1112,
                    'attrs'     => array(
                        'field' => 'a2',
                    )
                ),
                94 => array(
                    'weight'    => 1113,
                    'attrs'     => array(
                        'field' => 'a3',
                    )
                ),
            ),
            'total' => 3,
            'total_found' => 8,
        ));
        
        $this->assertEquals(3, count($resultSet));
        
        $this->assertEquals(3, $resultSet->count());
        
        $this->assertEquals(8, $resultSet->getTotalCount());
    }
}