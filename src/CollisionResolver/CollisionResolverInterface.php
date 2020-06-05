<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;

interface CollisionResolverInterface
{
    /**
     * @param RouteItem[]
     */
    public function resolve(array $routeItems): RouteItem;
}
