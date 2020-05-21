<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;

interface CollisionResolverInterface
{
    public function resolve(RouteItem ...$routeItems): RouteItem;
}
