<?php

namespace Application\Resource;

use Application\Entity\ItemEntity;
use Application\Entity\ItemsListEntity;
use Application\Environment\EnvironmentInterface;
use Hamlet\Entity\EntityLocationEnvelope;
use Hamlet\Request\RequestInterface;

class ItemListResource extends AbstractCollectionResource
{
    private $environment;
    private $uid;

    public function __construct(EnvironmentInterface $environment, $uid)
    {
        $this->environment = $environment;
        $this->uid = $uid;
    }

    public function isPutRequestValid(RequestInterface $request)
    {
        return $request->hasParameter('content');
    }

    protected function getCollection(RequestInterface $request)
    {
        $items = $this->environment->getDatabaseService()->getItems($this->uid);
        return new ItemsListEntity($items);
    }

    protected function createCollectionElement(RequestInterface $request)
    {
        $content = $request->getParameter('content');
        $id = $this->environment->getDatabaseService()->insertItem($this->uid, $content, false);

        $location = $this->environment->getCanonicalDomain() . '/items/' . $id;
        $entity = new ItemEntity($id, $content, false);

        return new EntityLocationEnvelope($location, $entity);
    }
}