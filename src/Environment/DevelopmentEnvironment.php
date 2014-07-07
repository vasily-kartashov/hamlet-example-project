<?php

namespace Application\Environment;

use Hamlet\Cache\TransientCache;

class DevelopmentEnvironment implements EnvironmentInterface
{
    public function getCache()
    {
        return new TransientCache();
    }
}