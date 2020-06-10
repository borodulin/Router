<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\CollisionResolver\FirstMatchResolver;
use PHPUnit\Framework\TestCase;

class FirstMatchResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $routeItems = [
            (new RouteItem())->setPriority(1),
            (new RouteItem())->setPriority(2),
            (new RouteItem())->setPriority(3),
        ];
        $resolver = new FirstMatchResolver();

        $this->assertEquals(1, $resolver->resolve($routeItems)->getPriority());
    }
}
