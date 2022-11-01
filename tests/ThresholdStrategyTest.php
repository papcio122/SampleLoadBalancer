<?php

use LoadBalancer\HostInterface;
use LoadBalancer\Strategy\ThresholdStrategy;
use PHPUnit\Framework\TestCase;

class ThresholdStrategyTest extends TestCase
{
    public function testFirstHostLoadLowerThenThreshold()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.5);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.55);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.56);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub1);
    }

    public function testLastHostLoadLowerThenThreshold()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.85);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.85);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.65);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub3);
    }

    public function testMiddleHostLoadLowerThenThreshold()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.85);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.65);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.85);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub2);
    }

    public function testNonHostLoadLowerThenThresholdFirstLowest()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.85);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.86);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.87);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub1);
    }

    public function testNonHostLoadLowerThenThresholdMiddleLowest()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.86);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.85);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.87);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub2);

    }

    public function testNonHostLoadLowerThenThresholdLastLowest()
    {
        $stub1 = $this->createStub(HostInterface::class);
        $stub1->method('getLoad')->willReturn(0.87);
        $stub2 = $this->createStub(HostInterface::class);
        $stub2->method('getLoad')->willReturn(0.86);
        $stub3 = $this->createStub(HostInterface::class);
        $stub3->method('getLoad')->willReturn(0.85);

        $strategy = new ThresholdStrategy([$stub1, $stub2, $stub3]);
        $host = $strategy->getNextHost();

        $this->assertSame($host, $stub3);
    }
}
