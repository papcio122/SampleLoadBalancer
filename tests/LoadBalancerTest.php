<?php

use LoadBalancer\LoadBalancer;
use LoadBalancer\Strategy\StrategyInterface;
use PHPUnit\Framework\TestCase;

class LoadBalancerTest extends TestCase
{
    public function testEmptyHostsList()
    {
        $strategyMock = $this->createMock(StrategyInterface::class);
        $this->expectException(Exception::class);

        $loadBalancer = new LoadBalancer([], $strategyMock);
    }
}
