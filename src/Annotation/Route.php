<?php

declare(strict_types=1);

namespace Borodulin\Router\Annotation;

use Borodulin\Router\Exception\InvalidConfigurationException;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class Route
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

    public function __construct(array $params)
    {
        if (isset($params['value'], $params['path'])) {
            throw new InvalidConfigurationException('');
        }
        $this->path = $params['value'] ?? $params['path'] ?? null;
        if (null === $this->path) {
            throw new InvalidConfigurationException('');
        }
        $this->path = $params['value'] ?? $params['path'] ?? null;
        $this->methods = $params['methods'] ?? ['GET'];
        $this->name = $params['name'] ?? null;
        $this->middlewares = $params['middlewares'] ?? [];
        $this->priority = $params['priority'] ?? 0;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
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

    /**
     * @return string[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
