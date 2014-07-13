<?php

namespace Application\Entity;

use Hamlet\Entity\JsonEntity;

class ItemsListEntity extends JSONEntity
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getKey()
    {
        return md5(serialize($this->items));
    }

    public function getData()
    {
        return $this->items;
    }
}