<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

class RouteTreeItem implements \Serializable
{
    /**
     * @var RouteTreeItem[]
     */
    private $valueChildren = [];
    /**
     * @var RouteTreeItem[]
     */
    private $expressionChildren = [];
    /**
     * @var RouteItem[]
     */
    private $routeItems = [];

    public function addValueChild(string $part): self
    {
        if (!isset($this->valueChildren[$part])) {
            $this->valueChildren[$part] = new static();
        }

        return $this->valueChildren[$part];
    }

    public function addExpressionChild(string $part): self
    {
        if (!isset($this->expressionChildren[$part])) {
            $this->expressionChildren[$part] = new static();
        }

        return $this->expressionChildren[$part];
    }

    public function getValueChild(string $part): ?self
    {
        return $this->valueChildren[$part] ?? null;
    }

    /**
     * @return RouteItem[]
     */
    public function getRouteItems(): array
    {
        return $this->routeItems;
    }

    public function addRouteItem(RouteItem $routeItem): self
    {
        $this->routeItems[] = $routeItem;

        return $this;
    }

    /**
     * @return RouteTreeItem[]
     */
    public function getValueChildren(): array
    {
        return $this->valueChildren;
    }

    /**
     * @return RouteTreeItem[]
     */
    public function getExpressionChildren(): array
    {
        return $this->expressionChildren;
    }

    public function normalizeValueChildren(callable $callable): void
    {
        usort($this->valueChildren, $callable);
        foreach ($this->valueChildren as $valueChild) {
            $valueChild->normalizeValueChildren($callable);
        }
    }

    public function normalizeExpressionChildren(callable $callable): void
    {
        usort($this->expressionChildren, $callable);
        foreach ($this->expressionChildren as $expressionChild) {
            $expressionChild->normalizeValueChildren($callable);
        }
    }

    public function serialize(): string
    {
        return serialize([$this->routeItems, $this->valueChildren]);
    }

    public function unserialize($serialized): void
    {
        [$this->routeItems, $this->valueChildren] = unserialize($serialized);
    }
}
