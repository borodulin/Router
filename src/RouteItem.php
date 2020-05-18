<?php

declare(strict_types=1);

namespace Borodulin\Router;

class RouteItem implements \Serializable, RouteItemInterface
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string[]
     */
    private $methods;
    /**
     * @var string[]
     */
    private $middlewares;
    /**
     * @var int
     */
    private $priority;

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param string[] $methods
     */
    public function setMethods(array $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param string[] $middlewares
     */
    public function setMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function serialize(): string
    {
        return serialize([
            $this->path,
            $this->name,
            $this->methods,
            $this->middlewares,
            $this->priority,
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->path,
            $this->name,
            $this->methods,
            $this->middlewares,
            $this->priority,
        ] = unserialize($serialized);
    }
}
