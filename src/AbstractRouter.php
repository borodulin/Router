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
     * @var ContainerInterface
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

        $middlewares = $this->routeItemFinder->getMiddlewares();
        $requestHandlers = $this->routeItemFinder->getRequestHandlers();
        if ($requestHandlers) {
            $handlerItem = (\count($requestHandlers) > 1)
                ? $this->collisionResolver->resolve($requestHandlers) : array_shift($requestHandlers);
            $handler = $this->createHandlerFromItem($handlerItem);
        } else {
            $handler = $defaultHandler;
        }

        return $this->createRouteMiddleware($middlewares, $handler);
    }

    private function createHandlerFromItem(RouteItem $routeItem): RequestHandlerInterface
    {
        $class = $routeItem->getTargetClass();

        return $this->container ? $this->container->get($class) : new $class();
    }

    private function createRouteMiddleware(array $middlewares, ?RequestHandlerInterface $handler): MiddlewareInterface
    {
        return new class($middlewares, $handler, $this->container) implements MiddlewareInterface {
            /**
             * @var MiddlewareInterface[]
             */
            private $middlewares;
            /**
             * @var RequestHandlerInterface|null
             */
            private $handler;
            /**
             * @var ContainerInterface|null
             */
            private $container;

            public function __construct(
                array $middlewares,
                RequestHandlerInterface $handler = null,
                ContainerInterface $container = null
            ) {
                $this->middlewares = $middlewares;
                $this->handler = $handler;
                $this->container = $container;
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $middlewareItem = array_shift($this->middlewares);
                $handler = $this->handler ?? $handler;
                if ($middlewareItem) {
                    $middleware = $this->createMiddlewareFromItem($middlewareItem);

                    return $middleware->process($request, $handler);
                }

                return $handler->handle($request);
            }

            private function createMiddlewareFromItem(RouteItem $routeItem): MiddlewareInterface
            {
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
