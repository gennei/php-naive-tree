<?php

namespace Gennei\NaiveTree;

class Organization implements TreeStructure
{
    private string $name;
    private ?TreeStructure $parent;
    private array $children = [];

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->parent = null;
    }

    public function addChild(TreeStructure $child): void
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    public function removeChild(TreeStructure $child): void
    {
        $index = array_search($child, $this->children);
        if ($index !== false) {
            unset($this->children[$index]);
        }
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getParent(): ?TreeStructure
    {
        return $this->parent;
    }

    public function setParent(TreeStructure $parent): void
    {
        $this->parent = $parent;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxDepth(): int
    {
        $maxDepth = 1;

        foreach ($this->getChildren() as $child) {
            $maxDepth = max($maxDepth, $child->getMaxDepth() + 1);
        }

        return $maxDepth;
    }

    public function toCSV(array $names = [], ?int $maxColumns = null): string
    {
        $names[] = $this->getName();
        $maxColumns = $maxColumns ?? $this->getMaxDepth();

        $filledNames = [...$names, ...array_fill(0, $maxColumns - count($names), "")];
        $currentRow = '"' . implode('", "', $filledNames) . '"';

        $csv = $currentRow . PHP_EOL;
        if ($this->getChildren()) {
            foreach ($this->getChildren() as $child) {
                $csv .= $child->toCSV(names: $names, maxColumns: $maxColumns);
            }
        }

        return $csv;
    }
}
