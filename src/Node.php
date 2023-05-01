<?php

namespace Gennei\NaiveTree;

readonly class Node
{
    public function __construct(public int $id, public string $name, public ?int $parentId)
    {
    }
}