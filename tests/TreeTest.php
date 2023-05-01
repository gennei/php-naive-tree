<?php

declare(strict_types=1);

namespace Gennei\NaiveTree\Tests;

use Gennei\NaiveTree\Node;
use Gennei\NaiveTree\Tree;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{

    /** @test */
    public function listをarrayに変換できる(): void
    {
        // arrange
        $tree = new Tree();
        $tree->add(new Node(1, 'node_1', null));
        $tree->add(new Node(2, 'node_2', 1));
        $tree->add(new Node(3, 'node_3', 1));
        $tree->add(new Node(4, 'node_4', 3));

        // act
        $actual = $tree->toArray();

        // assert
        $this->assertSame([
            [
                'id' => 1,
                'name' => 'node_1',
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'node_2',
                        'children' => [],
                    ],
                    [
                        'id' => 3,
                        'name' => 'node_3',
                        'children' => [
                            [
                                'id' => 4,
                                'name' => 'node_4',
                                'children' => [],
                            ]
                        ],
                    ]
                ]
            ]
        ], $actual);
    }
}