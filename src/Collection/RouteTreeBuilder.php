<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

use Borodulin\Router\Parser\PathParser;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteTreeBuilder
{
    /**
     * @var RouteTreeItem
     */
    private $routeTreeItem;
    /**
     * @var PathParser
     */
    private $pathParser;

    public function __construct()
    {
        $this->routeTreeItem = new RouteTreeItem();
        $this->pathParser = new PathParser();
    }

    public function addItem(RouteItem $routeItem): void
    {
        $pointer = $this->routeTreeItem;
        foreach ($this->pathParser->getPathParts($routeItem->getPath()) as $part) {
            $pointer = $this->pathParser->isExpression($part)
                ? $pointer->addExpression($part) : $pointer->addChild($part);
        }

        $reflectionClass = new \ReflectionClass($routeItem->getTargetClass());

        if ($reflectionClass->implementsInterface(MiddlewareInterface::class)) {
            $pointer->addMiddleware($routeItem);
        }
        if ($reflectionClass->implementsInterface(RequestHandlerInterface::class)) {
            $pointer->addRequestHandler($routeItem);
        }
    }

    public function getRouteTree(): RouteTreeItem
    {
        return $this->routeTreeItem;
    }
}
