<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;

class FirstMatchResolver implements CollisionResolverInterface
{
    public function resolve(RouteItem ...$routeItems): RouteItem
    {
        return $routeItems[0];
    }
}
