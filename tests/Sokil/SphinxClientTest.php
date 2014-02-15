<?php

namespace Sokil;

class SphinxClientTest extends \PHPUnit_Framework_TestCase
{
    public function testNativeSphinxClient()
    {
        $client = new \SphinxClient();
        $client->SetServer('127.0.0.1', 23023);
        $client->setMatchMode(SPH_MATCH_EXTENDED2);
        $client->setSortMode(SPH_SORT_RELEVANCE);
        $client->setLimits(0, 5, 5);
        
        $result = $client->query('"If you can" "keep"', 'idx_comments,idx_posts,');
        var_dump($client->getLastError());
        print_r($result);
        
        $this->assertNotEmpty($result);
    }
}