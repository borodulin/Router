<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Unit;

use Borodulin\Http\Message\ServerRequest;
use Borodulin\Http\Message\Uri;
use Borodulin\Router\Loader\AnnotationDirectoryLoader;
use Borodulin\Router\RouterBuilder;
use PHPUnit\Framework\TestCase;

class RouterBuilderTest extends TestCase
{
    public function testBuilder(): void
    {
        $loader = (new AnnotationDirectoryLoader())
              ->addPath(__DIR__.'/../Samples');
        $builder = new RouterBuilder($loader);
        $handler = $builder->buildHandler();
        $request = new ServerRequest();
        $request->withUri(new Uri('http://localhost/class-route'));
        $response = $handler->handle($request);
        $this->assertTrue(true);
    }
}
