<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Samples;

use Borodulin\Router\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @Route("/route", methods={"GET", "POST"}, tag="test1")
 */
class MiddlewareRouter implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
}
