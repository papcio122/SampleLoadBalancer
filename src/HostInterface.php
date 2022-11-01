<?php

namespace LoadBalancer;

interface HostInterface
{
    public function getLoad(): float;
    public function handleRequest(Request $request);
}