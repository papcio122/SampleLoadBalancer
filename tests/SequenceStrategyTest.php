<?php

use LoadBalancer\HostInterface;
use LoadBalancer\Strategy\SequenceStrategy;
use PHPUnit\Framework\TestCase;

class SequenceStrategyTest extends TestCase
{
    public function testRequestCountLowerThenHostsCount()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub2 = $this->createStub(HostInterface::class);
        $stub3 = $this->createStub(HostInterface::class);

        $strategy = new SequenceStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub1);
    }

    public function testRequestCountEqualsToHostsCount()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub2 = $this->createStub(HostInterface::class);
        $stub3 = $this->createStub(HostInterface::class);

        $strategy = new SequenceStrategy([$stub1, $stub2, $stub3]);
        $strategy->getNextHost();
        $strategy->getNextHost();
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub3);
    }

    public function testRequestCountHigherThenHostsCount()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub2 = $this->createStub(HostInterface::class);
        $stub3 = $this->createStub(HostInterface::class);

        $strategy = new SequenceStrategy([$stub1, $stub2, $stub3]);
        $strategy->getNextHost();
        $strategy->getNextHost();
        $strategy->getNextHost();
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub1);
    }
}
