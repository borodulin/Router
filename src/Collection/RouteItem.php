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

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
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

    public function serialize(): string
    {
        return serialize([
            $this->methods,
            $this->tag,
            $this->priority,
            $this->options,
            $this->targetClass,
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->methods,
            $this->tag,
            $this->priority,
            $this->options,
            $this->targetClass,
        ] = unserialize($serialized);
    }
}
