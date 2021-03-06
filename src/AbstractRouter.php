<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\Collection\RouteItemFinder;
use Borodulin\Router\CollisionResolver\CollisionResolverInterface;
use Borodulin\Router\CollisionResolver\ThrowErrorResolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractRouter
{
    /**
     * @var ContainerInterface|null
     */
    private $container;
    /**
     * @var CollisionResolverInterface
     */
    private $collisionResolver;
    /**
     * @var RouteItemFinder
     */
    private $routeItemFinder;

    public function __construct(RouteItemFinder $routeItemFinder)
    {
        $this->routeItemFinder = $routeItemFinder;
        $this->collisionResolver = new ThrowErrorResolver();
    }

    protected function processRequest(
        ServerRequestInterface $request,
        RequestHandlerInterface $defaultHandler = null
    ): MiddlewareInterface {
        $this->routeItemFinder->find($request->getUri()->getPath(), $request->getMethod());

        $middlewareItems = $this->routeItemFinder->getMiddlewares();
        $requestHandlers = $this->routeItemFinder->getRequestHandlers();
        if ($requestHandlers) {
            $handlerItem = (\count($requestHandlers) > 1)
                ? $this->collisionResolver->resolve($requestHandlers) : array_shift($requestHandlers);
            $handler = $this->createHandlerFromItem($handlerItem);
        } else {
            $handler = $defaultHandler;
        }

        return $this->createRouteMiddleware($middlewareItems, $handler);
    }

    private function createHandlerFromItem(RouteItem $routeItem): RequestHandlerInterface
    {
        /** @var RequestHandlerInterface|object|string $class */
        $class = $routeItem->getTargetClass();

        return $this->container ? $this->container->get($class) : new $class();
    }

    /**
     * @param RouteItem[] $middlewareItems
     */
    private function createRouteMiddleware(array $middlewareItems, ?RequestHandlerInterface $handler): MiddlewareInterface
    {
        return new class($middlewareItems, $handler, $this->container) implements MiddlewareInterface {
            /**
             * @var RouteItem[]
             */
            private $middlewareItems;
            /**
             * @var RequestHandlerInterface|null
             */
            private $handler;
            /**
             * @var ContainerInterface|null
             */
            private $container;

            /**
             * @param RouteItem[] $middlewareItems
             */
            final public function __construct(
                array $middlewareItems,
                RequestHandlerInterface $handler = null,
                ContainerInterface $container = null
            ) {
                $this->middlewareItems = $middlewareItems;
                $this->handler = $handler;
                $this->container = $container;
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $middlewareItem = array_shift($this->middlewareItems);
                $handler = $this->handler ?? $handler;
                if ($middlewareItem) {
                    $middleware = $this->createMiddlewareFromItem($middlewareItem);

                    return $middleware->process($request, $handler);
                }

                return $handler->handle($request);
            }

            private function createMiddlewareFromItem(RouteItem $routeItem): MiddlewareInterface
            {
                /** @var MiddlewareInterface|object|string $class */
                $class = $routeItem->getTargetClass();

                return $this->container ? $this->container->get($class) : new $class();
            }
        };
    }

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function setCollisionResolver(CollisionResolverInterface $collisionResolver): self
    {
        $this->collisionResolver = $collisionResolver;

        return $this;
    }
}
