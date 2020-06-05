<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

use Borodulin\Router\Parser\PathParser;

class RouteItemFinder
{
    /**
     * @var RouteTreeItem
     */
    private $routeTreeItem;
    /**
     * @var PathParser
     */
    private $parser;
    /**
     * @var RouteItem[]
     */
    private $middlewares = [];
    /**
     * @var RouteItem[]
     */
    private $requestHandlers = [];

    public function __construct(RouteTreeItem $routeTreeItem)
    {
        $this->routeTreeItem = $routeTreeItem;
        $this->parser = new PathParser();
    }

    public function find(string $path, string $method): bool
    {
        $this->middlewares = [];
        $this->requestHandlers = [];
        $routeTreeItems = [$this->routeTreeItem];
        foreach ($this->parser->getPathParts($path) as $part) {
            $routeTreeItems = $this->findChildren($routeTreeItems, $part);
            if (empty($routeTreeItems)) {
                return false;
            }
            $this->findMiddlewares($routeTreeItems, $method);
        }
        $this->findHandlers($routeTreeItems, $method);

        return !empty($this->requestHandlers);
    }

    /**
     * @param RouteTreeItem[] $routeTreeItems
     *
     * @return RouteTreeItem[]
     */
    private function findChildren(array $routeTreeItems, string $part): array
    {
        $result = [];
        foreach ($routeTreeItems as $routeTreeItem) {
            $valueChild = $routeTreeItem->getChild($part);
            if (null !== $valueChild) {
                $result[] = $valueChild;
                continue;
            }
            foreach ($routeTreeItem->getExpressions() as $expression => $expressionChild) {
                if ($this->parser->match($expression, $part)) {
                    $result[] = $expressionChild;
                }
            }
        }

        return $result;
    }

    /**
     * @param RouteTreeItem[] $routeTreeItems
     */
    private function findMiddlewares(array $routeTreeItems, string $method): void
    {
        foreach ($routeTreeItems as $foundItem) {
            foreach ($foundItem->getMiddlewares() as $routeItem) {
                if (\in_array($method, $routeItem->getMethods())) {
                    $this->middlewares[$routeItem->getTargetClass()] = $routeItem;
                }
            }
        }
    }


    /**
     * @param RouteTreeItem[] $routeTreeItems
     */
    private function findHandlers(array $routeTreeItems, string $method): void
    {
        foreach ($routeTreeItems as $foundItem) {
            foreach ($foundItem->getRequestHandlers() as $routeItem) {
                if (\in_array($method, $routeItem->getMethods())) {
                    $this->requestHandlers[$routeItem->getTargetClass()] = $routeItem;
                }
            }
        }
    }

    /**
     * @return RouteItem[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @return RouteItem[]
     */
    public function getRequestHandlers(): array
    {
        return $this->requestHandlers;
    }
}
