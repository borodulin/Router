<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Psr\Http\Server\RequestHandlerInterface;

class Router implements RouterInterface
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }


    public function match(string $path): RequestHandlerInterface
    {
        return new RouteItem();
    }
}
