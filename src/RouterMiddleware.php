<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouterMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router, ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $item = $this->router->match($request->getMethod());
        if (null !== $item) {
            return $item->handle($request);
        }

        return $handler->handle($request);
    }
}
