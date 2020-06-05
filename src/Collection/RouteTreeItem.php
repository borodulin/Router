<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

class RouteTreeItem implements \Serializable
{
    /**
     * @var RouteTreeItem[]
     */
    private $children = [];

    /**
     * @var RouteTreeItem[]
     */
    private $expressions = [];

    /**
     * @var RouteItem[]
     */
    private $requestHandlers = [];

    /**
     * @var RouteItem[]
     */
    private $middlewares = [];

    public function addChild(string $part): self
    {
        if (!isset($this->children[$part])) {
            $this->children[$part] = new static();
        }

        return $this->children[$part];
    }

    public function addExpression(string $part): self
    {
        if (!isset($this->expressions[$part])) {
            $this->expressions[$part] = new static();
        }

        return $this->expressions[$part];
    }

    public function addMiddleware(RouteItem $routeItem): self
    {
        $this->middlewares[] = $routeItem;

        return $this;
    }

    public function addRequestHandler(RouteItem $routeItem): self
    {
        $this->requestHandlers[] = $routeItem;

        return $this;
    }

    public function getChild(string $part): ?self
    {
        return $this->children[$part] ?? null;
    }

    /**
     * @return RouteTreeItem[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return RouteTreeItem[]
     */
    public function getExpressions(): array
    {
        return $this->expressions;
    }

    private function normalizeChildren(callable $callable): void
    {
        usort($this->middlewares, $callable);
        usort($this->requestHandlers, $callable);

        foreach ($this->children as $child) {
            $child->normalizeChildren($callable);
        }
        foreach ($this->expressions as $expression) {
            $expression->normalizeChildren($callable);
        }
    }

    public function normalize(): void
    {
        $compareFunc = static function (RouteItem $item1, RouteItem $item2) {
            return $item1->getPriority() <=> $item2->getPriority();
        };
        $this->normalizeChildren($compareFunc);
    }

    public function serialize(): string
    {
        return serialize([
            $this->children, $this->expressions, $this->middlewares, $this->requestHandlers,
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->children, $this->expressions, $this->middlewares, $this->requestHandlers,
        ] = unserialize($serialized);
    }

    /**
     * @return RouteItem[]
     */
    public function getRequestHandlers(): array
    {
        return $this->requestHandlers;
    }

    /**
     * @return RouteItem[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
