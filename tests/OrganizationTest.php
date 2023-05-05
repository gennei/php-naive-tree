<?php

declare(strict_types=1);

use Gennei\NaiveTree\Organization;
use PHPUnit\Framework\TestCase;

final class OrganizationTest extends TestCase
{
    public function testAddChild(): void
    {
        $parent = new Organization("親");
        $child = new Organization("子");

        $parent->addChild($child);

        $this->assertSame($parent->getChildren()[0], $child);
    }

    public function testRemoveChild(): void
    {
        $parent = new Organization("親");
        $child = new Organization("子");

        $parent->addChild($child);
        $parent->removeChild($child);

        $this->assertEmpty($parent->getChildren());
    }

    public function testParentSetting(): void
    {
        $parent = new Organization("親");
        $child = new Organization("子");

        $parent->addChild($child);

        $this->assertSame($child->getParent(), $parent);
    }

    public function testToCSV(): void
    {
        $parent = new Organization("親");
        $child1 = new Organization("子1");
        $child2 = new Organization("子2");
        $grandchild = new Organization("孫");

        $parent->addChild($child1);
        $parent->addChild($child2);
        $child1->addChild($grandchild);

        $expectedCsv = <<<CSV
"親", "", ""
"親", "子1", ""
"親", "子1", "孫"
"親", "子2", ""
CSV;

        $csv = $parent->toCSV();
        $this->assertSame($expectedCsv, rtrim($csv, PHP_EOL));
    }
}
