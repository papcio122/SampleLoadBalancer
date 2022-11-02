<?php

namespace LoadBalancer\Strategy;

use LoadBalancer\HostInterface;

interface StrategyInterface
{
    public function __construct(array $hosts);

    public function getNextHost(): HostInterface;
}