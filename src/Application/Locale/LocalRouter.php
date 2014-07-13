<?php

namespace Application\Locale;

use Application\Environment\EnvironmentInterface;
use Hamlet\Request\RequestInterface;
use Hamlet\Resource\EntityResource;
use Hamlet\Resource\RedirectResource;

class LocaleRouter
{
    protected $locale;
    protected $localeName;
    protected $environment;

    public function __construct(Locale $locale, EnvironmentInterface $environment)
    {
        $this->locale = $locale;
        $this->localeName = $locale->getLocaleName();
        $this->environment = $environment;
    }

    public function findResource(RequestInterface $request)
    {
        if ($request->pathMatches($this->getHomepagePattern())) {
            return new EntityResource(new HomePageEntity($this->locale, $this->environment));
        }
        return new RedirectResource($this->getHomepagePath());
    }

    public function getHomepagePath()
    {
        return $this->getHomepagePattern();
    }

    protected function getHomepagePattern()
    {
        return '/' . $this->localeName ;
    }

    protected function translatePath($token)
    {
        return strtolower(str_replace(' ', '-', $this->locale->translate($token)));
    }
}