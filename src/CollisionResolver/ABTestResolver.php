<?php

declare(strict_types=1);

namespace Borodulin\Router\CollisionResolver;

use Borodulin\Router\Collection\RouteItem;

class ABTestResolver implements CollisionResolverInterface
{
    public function resolve(array $routeItems): RouteItem
    {
        $randomItem = null;
        $prevSigma = 0;
        foreach ($routeItems as $routeItem) {
            $weight = ($routeItem->getOptions()['weight'] ?? null) ?: 1;
            $sigma = (random_int(1, PHP_INT_MAX) / PHP_INT_MAX) ** (1 / $weight);
            if ($sigma > $prevSigma) {
                $prevSigma = $sigma;
                $randomItem = $routeItem;
            }
        }

        return $randomItem;
    }
}
