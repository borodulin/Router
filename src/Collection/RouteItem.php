<?php

declare(strict_types=1);

namespace Borodulin\Router\Collection;

class RouteItem implements \Serializable
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var string[]
     */
    private $methods;
    /**
     * @var string|null
     */
    private $tag;
    /**
     * @var array
     */
    private $options;
    /**
     * @var string
     */
    private $targetClass;
    /**
     * @var int
     */
    private $priority;
    /**
     * @var bool
     */
    private $isMiddleware;
    /**
     * @var bool
     */
    private $isRequestHandler;

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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

    public function getTargetClass(): string
    {
        return $this->targetClass;
    }

    public function setTargetClass(string $targetClass): self
    {
        $this->targetClass = $targetClass;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

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

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function isMiddleware(): bool
    {
        return $this->isMiddleware;
    }

    public function setIsMiddleware(bool $isMiddleware): self
    {
        $this->isMiddleware = $isMiddleware;

        return $this;
    }

    public function isRequestHandler(): bool
    {
        return $this->isRequestHandler;
    }

    public function setIsRequestHandler(bool $isRequestHandler): self
    {
        $this->isRequestHandler = $isRequestHandler;

        return $this;
    }

    public function serialize(): string
    {
        return serialize([
            $this->path,
            $this->name,
            $this->methods,
            $this->tag,
            $this->priority,
            $this->options,
            $this->targetClass,
            $this->isMiddleware,
            $this->isRequestHandler,
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->path,
            $this->name,
            $this->methods,
            $this->tag,
            $this->priority,
            $this->options,
            $this->targetClass,
            $this->isMiddleware,
            $this->isRequestHandler,
        ] = unserialize($serialized);
    }
}
