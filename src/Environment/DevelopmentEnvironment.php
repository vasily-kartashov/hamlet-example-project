<?php

namespace Application\Environment;

use Hamlet\Cache\NoCache;

class DevelopmentEnvironment implements EnvironmentInterface
{
    public function getCache()
    {
        return new NoCache();
    }
}