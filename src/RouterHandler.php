<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Borodulin\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouterHandler extends AbstractRouter implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->processRequest($request);

        return $middleware->process($request, $this->createRouteNotFoundHandler());
    }

    private function createRouteNotFoundHandler(): RequestHandlerInterface
    {
        return new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw new RouteNotFoundException();
            }
        };
    }
}
