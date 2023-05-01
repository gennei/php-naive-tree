<?php

namespace Gennei\NaiveTree;

use JsonSerializable;

class Tree implements JsonSerializable
{
    /** @var Node[] */
    private array $nodes = [];

    public function add(Node $node): void
    {
        $this->nodes[] = $node;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $roots = array_filter($this->nodes, fn(Node $node) => $node->parentId === null);
        if ($roots === []) {
            return [];
        }

        $tmp = [];
        foreach ($roots as $node) {
            $tmp[] = [
                'id' => $node->id,
                'name' => $node->name,
                'children' => $this->getChildren($node),
            ];
        }

        return $tmp;
    }

    /**
     * @param Node $parentNode
     * @return array
     */
    private function getChildren(Node $parentNode): array
    {
        $nodes = [];
        foreach ($this->nodes as $node) {
            if ($node->parentId === $parentNode->id) {
                $nodes[] = [
                    'id' => $node->id,
                    'name' => $node->name,
                    'children' => $this->getChildren($node),
                ];
            }
        }

        return $nodes;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}