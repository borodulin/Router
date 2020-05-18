<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Borodulin\Router\Exception\RouteNotFoundException;
use Borodulin\Router\Http\Factory\ResponseFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouterHandler implements RequestHandlerInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router, ResponseFactoryInterface $responseFactory = null)
    {
        $this->responseFactory = $responseFactory ?? new ResponseFactory();
        $this->router = $router;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $item = $this->router->match($request->getMethod());
        if (null !== $item) {
            return $item->handle($request);
        }
        throw new RouteNotFoundException();
    }
}
