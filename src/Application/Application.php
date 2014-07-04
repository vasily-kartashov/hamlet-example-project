<?php

namespace Application;

use Application\Environment\DevelopmentEnvironment;
use Hamlet\Application\AbstractApplication;
use Hamlet\Entity\JsonEntity;
use Hamlet\Request\RequestInterface;
use Hamlet\Resource\EntityResource;

class Application extends AbstractApplication
{
    private $cache;

    protected function findResource(RequestInterface $request)
    {
        return new EntityResource(new JsonEntity('hello world'));
    }

    protected function getCache(RequestInterface $request)
    {
        if (is_null($this->cache)) {
            $environment = $this->getEnvironment($request);
            $this->cache = $environment->getCache();
        }
        return $this->cache;
    }

    protected function getEnvironment(RequestInterface $request)
    {
        return new DevelopmentEnvironment();
    }
}