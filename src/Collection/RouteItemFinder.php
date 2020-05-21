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

    public function __construct(RouteTreeItem $routeTreeItem)
    {
        $this->routeTreeItem = $routeTreeItem;
        $this->parser = new PathParser();
    }

    /**
     * @return RouteTreeItem[]
     */
    public function findRouteTreeItems(string $path): array
    {
        $routeTreeItems = [$this->routeTreeItem];
        foreach ($this->parser->getPathParts($path) as $part) {
            $routeTreeItems = $this->findChildren($routeTreeItems, $part);
            if (empty($routeTreeItems)) {
                break;
            }
        }

        return $routeTreeItems;
    }

    /**
     * @param RouteTreeItem[] $routeTreeItems
     *
     * @return \Traversable|RouteItem[]
     */
    public function findRouteItems(array $routeTreeItems, string $method): \Traversable
    {
        foreach ($routeTreeItems as $foundItem) {
            foreach ($foundItem->getRouteItems() as $routeItem) {
                if (\in_array($method, $routeItem->getMethods())) {
                    yield $routeItem;
                }
            }
        }
    }

    /**
     * @param RouteTreeItem[] $routeTreeItems
     *
     * @return RouteTreeItem[]
     */
    private function findChildren(array $routeTreeItems, string $part): array
    {
        $result = [];
        foreach ($routeTreeItems as $value => $routeTreeItem) {
            $valuesChild = $routeTreeItem->getValueChild($part);
            if (null !== $valuesChild) {
                $result[$value] = $valuesChild;
            } else {
                foreach ($routeTreeItem->getExpressionChildren() as $expression => $expressionChild) {
                    if ($this->parser->match($expression, $part)) {
                        $result[$expression] = $expressionChild;
                    }
                }
            }
        }

        return $result;
    }
}
