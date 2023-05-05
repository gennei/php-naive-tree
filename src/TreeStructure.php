<?php

namespace Gennei\NaiveTree;

interface TreeStructure {
    public function addChild(TreeStructure $child): void;
    public function removeChild(TreeStructure $child): void;
    public function getChildren(): array;
    public function getParent(): ?TreeStructure;
    public function setParent(TreeStructure $parent): void;
    public function toCSV(array $names = []): string;
}