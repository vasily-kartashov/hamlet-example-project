<?php

namespace Application\Environment;

interface EnvironmentInterface
{
    /**
     * Get cache implementation for the environment
     *
     * @return \Hamlet\Cache\CacheInterface
     */
    public function getCache();
}