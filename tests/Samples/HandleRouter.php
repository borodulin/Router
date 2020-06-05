<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Samples;

use Borodulin\Http\Message\Response;
use Borodulin\Router\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @Route("/route")
 */
class HandleRouter implements RequestHandlerInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}
