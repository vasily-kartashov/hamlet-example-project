<?php

namespace Application\Entity;

use Hamlet\Entity\JsonEntity;

class ItemEntity extends JsonEntity
{
    private $id;
    private $content;
    private $done;

    public function __construct($id, $content, $done)
    {
        $this->id = $id;
        $this->content = (string) $content;
        $this->done = (bool) $done;
    }

    public function getKey()
    {
        return md5(serialize($this->getData()));
    }

    public function getData()
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'done' => $this->done,
        ];
    }
}