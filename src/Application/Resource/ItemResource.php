<?php

namespace Application\Resource;

use Application\Entity\ItemEntity;
use Application\Environment\EnvironmentInterface;
use Hamlet\Request\RequestInterface;
use Hamlet\Response\BadRequestResponse;
use Hamlet\Response\MethodNotAllowedResponse;
use Hamlet\Response\NoContentResponse;

class ItemResource extends AbstractCollectionElementResource
{
    private $environment;
    private $itemId;
    private $uid;
    private $operation;

    public function __construct(EnvironmentInterface $environment, $itemId, $uid, $operation = null)
    {
        $this->environment = $environment;
        $this->itemId = $itemId;
        $this->uid = $uid;
        $this->operation = $operation;
    }

    protected function isPutRequestValid(RequestInterface $request)
    {
        return $request->hasParameter('content');
    }

    protected function collectionElementExists(RequestInterface $request)
    {
        return $this->environment->getDatabaseService()->itemExists($this->itemId, $this->uid);
    }

    protected function deleteCollectionElement(RequestInterface $request)
    {
        $this->environment->getDatabaseService()->deleteItem($this->itemId, $this->uid);
    }

    protected function updateCollectionElement(RequestInterface $request)
    {
        $this->environment->getDatabaseService()->updateItemContent($this->itemId, $this->uid, $request->getParameter('content'));
    }

    protected function getCollectionElement(RequestInterface $request)
    {
        $item = $this->environment->getDatabaseService()->getItem($this->itemId, $this->uid);
        return new ItemEntity($item['id'], $item['content'], $item['done']);
    }

    protected function updateItem($itemId, $done)
    {
        $this->environment->getDatabaseService()->updateItemStatus($itemId, $this->uid, $done);
        return new NoContentResponse();
    }

    public function getResponse(RequestInterface $request)
    {
        if ($this->operation == null) {
            return parent::getResponse($request);
        }
        if ($request->getMethod() == 'POST') {
            switch ($this->operation) {
                case 'do':
                    return $this->updateItem($this->itemId, true);
                case 'undo':
                    return $this->updateItem($this->itemId, false);
                default:
                    return new BadRequestResponse();
            }
        } else {
            return new MethodNotAllowedResponse(['POST']);
        }
    }
}