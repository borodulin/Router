<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

use Borodulin\Router\Parser\PathParser;

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

    public function addItem(RouteItem $item): void
    {
        $pointer = $this->routeTreeItem;
        foreach ($this->pathParser->getPathParts($item->getPath()) as $part) {
            $pointer = $this->pathParser->isExpression($part)
                ? $pointer->addExpressionChild($part) : $pointer->addValueChild($part);
        }
        $pointer->addRouteItem($item);
    }

    public function normalize(): void
    {
        $this->routeTreeItem->normalizeValueChildren([static::class, 'compareItems']);
        $this->routeTreeItem->normalizeExpressionChildren([static::class, 'compareItems']);
    }

    public static function compareItems(RouteItem $item1, RouteItem $item2): int
    {
        $cmp = (int) $item1->isMiddleware() <=> (int) $item2->isMiddleware();

        return (0 !== $cmp) ? $cmp : $item1->getPriority() <=> $item2->getPriority();
    }

    public function getRouteTree(): RouteTreeItem
    {
        return $this->routeTreeItem;
    }
}
