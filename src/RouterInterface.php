<?php

declare(strict_types=1);

namespace Borodulin\Router;

use Psr\Http\Server\RequestHandlerInterface;

interface RouterInterface
{
    public function match(string $path): ?RequestHandlerInterface;
}
