<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\Collection\RouteItemFinder;
use Borodulin\Router\Collection\RouteTreeBuilder;
use Borodulin\Router\Collection\RouteTreeItem;
use Borodulin\Router\Exception\InvalidConfigurationException;
use Borodulin\Router\Loader\LoaderInterface;
use Psr\SimpleCache\CacheInterface;

class RouterBuilder
{
    /**
     * @var CacheInterface|null
     */
    private $cache;
    /**
     * @var LoaderInterface
     */
    private $loader;
    /**
     * @var int
     */
    private static $versionId = 0;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function buildMiddleware(): RouterMiddleware
    {
        return new RouterMiddleware(new RouteItemFinder($this->loadItems()));
    }

    public function buildHandler(): RouterHandler
    {
        return new RouterHandler(new RouteItemFinder($this->loadItems()));
    }

    public function setCache(CacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    private function loadItems(): RouteTreeItem
    {
        $cacheKey = self::class.++self::$versionId;
        if ($this->cache && $this->cache->has($cacheKey)) {
            /** @var RouteTreeItem $items */
            $items = unserialize($this->cache->get($cacheKey));
        } else {
            $items = $this->load();
            if ($this->cache) {
                $this->cache->set($cacheKey, serialize($items));
            }
        }

        return $items;
    }

    private function load(): RouteTreeItem
    {
        $routeTreeBuilder = new RouteTreeBuilder();
        foreach ($this->loader as $item) {
            if (!$item instanceof RouteItem) {
                throw new InvalidConfigurationException();
            }
            $routeTreeBuilder->addItem($item);
        }
        $routeTreeBuilder->getRouteTree()->normalize();

        return $routeTreeBuilder->getRouteTree();
    }
}
