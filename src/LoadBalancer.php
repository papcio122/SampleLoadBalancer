<?php

namespace LoadBalancer;

use LoadBalancer\Strategy\StrategyInterface;

class LoadBalancer
{
    /**
     * @throws \Exception
     */
    public function __construct(array $hosts, private StrategyInterface $strategy)
    {
        if (empty($hosts)) {
            throw new \Exception('Empty hosts list');
        }
    }

    public function handleRequest(Request $request)
    {
        $host = $this->strategy->getNextHost();
        $host->handleRequest($request);
    }
}