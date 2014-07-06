<?php

namespace Application;

use Application\Environment\DevelopmentEnvironment;
use Hamlet\Application\AbstractApplication;
use Hamlet\Request\RequestInterface;
use Hamlet\Resource\JsonEntityResource;

class Application extends AbstractApplication
{
    private $cache;

    protected function findResource(RequestInterface $request)
    {
        if ($request->hasParameter('name')) {
            $message = 'Hello, ' . $request->getParameter('name') . '!';
        } else {
            $message = 'Hello, World!';
        }
        return new JsonEntityResource($message);
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