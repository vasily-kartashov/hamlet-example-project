<?php

namespace Application\Entity;

use Application\Environment\EnvironmentInterface;
use Application\Locale\Locale;

class HomePageEntity extends AbstractBasePageEntity
{
    public function __construct(Locale $locale, EnvironmentInterface $environment)
    {
        parent::__construct($locale,$environment);
    }

    public function getTemplatePath()
    {
        return __DIR__ . '/template/home.tpl';
    }

    public function getKey()
    {
        return __CLASS__ . get_class($this->locale);
    }

    protected function getContentData()
    {
        return array(
            'greeting' => $this->locale->translate('token-hello'),
        );
    }

    protected function getPageTitle()
    {
        return 'Homepage';
    }
}