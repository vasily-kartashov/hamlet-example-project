<?php

namespace Application;

use Application\Environment\DevelopmentEnvironment;
use Hamlet\Application\AbstractApplication;
use Hamlet\Request\RequestInterface;
use Hamlet\Resource\RedirectResource;

class Application extends AbstractApplication
{
    private $cache;

    protected function findResource(RequestInterface $request)
    {
        $environment = $this->getEnvironment($request);

        $uid = $this->getUid($request);
        if ($uid) {
            if ($request->pathMatchesPattern('/items')) {
                return new ItemsListResource($environment, $uid);
            }
            if ($matches = $request->pathMatchesPattern('/items/{itemId}')) {
                return new ItemResource($environment, $matches['itemId'], $uid);
            }
            if ($matches = $request->pathMatchesPattern('/items/{itemId}/{operation}')) {
                return new ItemResource($environment, $matches['itemId'], $uid, $matches['operation']);
            }
        } else {
            // @todo add not allowed response
        }

        if ($matches = $request->pathStartsWithPattern('/{localeName}')) {
            if ($environment->localeExists($matches['localeName'])) {
                $locale = $environment->getLocale($matches['localeName']);
                $localeRouter = new LocaleRouter($locale,$environment);
                return $localeRouter->findResource($request);
            }
        }
        return new RedirectResource($environment->getCanonicalDomain() . '/en');
    }

    protected function getUid(RequestInterface $request)
    {
        $authorization = $request->getHeader('Authorization');
        if (!$authorization) {
            return null;
        }
        list($_, $accessToken) = explode(' ', $authorization, 2);
        $cache = $this->getCache($request);
        list($uid, $found) = $cache->get($accessToken);
        if (!$found) {
            $content = json_decode(file_get_contents("https://graph.facebook.com/me?access_token={$accessToken}"));
            $uid = $content->id;
            $cache->set($accessToken, $uid, time() + 3600);
        }
        return $uid;
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