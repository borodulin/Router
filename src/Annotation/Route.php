<?php

declare(strict_types=1);

namespace Borodulin\Router\Annotation;

use Borodulin\Router\Exception\InvalidConfigurationException;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Route
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
     * @var array
     * @Enum({"GET","HEAD","POST","PUT","DELETE","CONNECT","OPTIONS","TRACE","PATCH"})
     */
    private $methods;
    /**
     * @var string|null
     */
    private $tag;
    /**
     * @var int
     */
    private $priority;
    /**
     * @var array
     */
    private $options;

    public function __construct(array $params)
    {
        if (isset($params['value'], $params['path'])) {
            throw new InvalidConfigurationException('Route path is required.');
        }
        $this->path = $params['value'] ?? $params['path'] ?? null;
        if (!\is_string($this->path)) {
            throw new InvalidConfigurationException("Invalid route path: '$this->path'.");
        }
        $this->methods = $params['methods'] ?? ['GET'];
        $this->name = $params['name'] ?? null;
        $this->tag = $params['tag'] ?? null;
        $this->priority = $params['priority'] ?? 0;
        $this->options = $params['options'] ?? [];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
