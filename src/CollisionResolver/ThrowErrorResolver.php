<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\Exception\RouteNotFoundException;

class ThrowErrorResolver implements CollisionResolverInterface
{
    public function resolve(array $routeItems): RouteItem
    {
        throw new RouteNotFoundException();
    }
}
