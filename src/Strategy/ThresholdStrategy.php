<?php

namespace LoadBalancer\Strategy;

use LoadBalancer\HostInterface;

class ThresholdStrategy implements StrategyInterface
{

    public function __construct(private array $hosts)
    {}

    public function getNextHost(): HostInterface
    {
        $lowestLoad = PHP_FLOAT_MAX;
        $lowestKey = 0;
        /**
         * @var int $key
         * @var HostInterface $host
         */
        foreach ($this->hosts as $key => $host) {
            $load = $host->getLoad();
            if ($load < 0.75) {
                return $host;
            }
            if ($load < $lowestLoad) {
                $lowestLoad = $load;
                $lowestKey = $key;
            }
        }

        return $this->hosts[$lowestKey];
    }
}