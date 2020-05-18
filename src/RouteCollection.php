<?php

declare(strict_types=1);

namespace Borodulin\Router;

class RouteCollection implements \Serializable
{
    private $routeTree;

    private $routeList;

    public function serialize(): string
    {
        return serialize([$this->routeTree, $this->routeList]);
    }

    public function unserialize($serialized): void
    {
        [$this->routeTree, $this->routeList] = unserialize($serialized);
    }
}
