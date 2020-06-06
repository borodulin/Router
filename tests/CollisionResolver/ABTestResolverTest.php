<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\CollisionResolver\ABTestResolver;
use PHPUnit\Framework\TestCase;

class ABTestResolverTest extends TestCase
{
    public function testRandom(): void
    {
        /** @var RouteItem[] $routeItems */
        $routeItems = [
            (new RouteItem())->setOptions(['weight' => 20]),
            (new RouteItem())->setOptions(['weight' => 30]),
            (new RouteItem())->setOptions(['weight' => 50]),
        ];
        $abTestResolver = new ABTestResolver();
        for ($i = 0; $i < 200; ++$i) {
            $routeItem = $abTestResolver->resolve($routeItems);
            $routeItem->setPriority($routeItem->getPriority() + 1);
        }
        foreach ($routeItems as $routeItem) {
            $weight = $routeItem->getOptions()['weight'];
            $this->assertLessThanOrEqual($weight * 2 + 10, $routeItem->getPriority());
            $this->assertGreaterThanOrEqual($weight * 2 - 10, $routeItem->getPriority());
        }
    }
}
