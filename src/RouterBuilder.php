<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class RouterBuilder
{
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct()
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function build(): Router
    {
        $cacheKey = self::class;
        if ($this->cache && $this->cache->has($cacheKey)) {
            /** @var RouteCollection $items */
            $items = unserialize($this->cache->get($cacheKey));
        } else {
            $items = new RouteCollection();
        }

        return new Router($items);
    }

    public function setCache(CacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }
}
