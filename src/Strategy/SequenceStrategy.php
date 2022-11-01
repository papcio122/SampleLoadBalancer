<?php

namespace LoadBalancer\Strategy;

use LoadBalancer\HostInterface;

class SequenceStrategy implements StrategyInterface
{

    private \ArrayIterator $iterator;

    public function __construct(array $hosts)
    {
        $this->iterator = new \ArrayIterator($hosts);
    }

    public function getNextHost(): HostInterface
    {
        if (!$this->iterator->valid()){
            $this->iterator->rewind();
        }

        $host = $this->iterator->current();
        $this->iterator->next();

        return $host;
    }
}