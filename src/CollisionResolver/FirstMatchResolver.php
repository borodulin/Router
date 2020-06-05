<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;

class FirstMatchResolver implements CollisionResolverInterface
{
    public function resolve(array $routeItems): RouteItem
    {
        return array_shift($routeItems);
    }
}
