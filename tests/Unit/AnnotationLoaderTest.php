<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Unit;

use Borodulin\Router\Loader\AnnotationDirectoryLoader;
use PHPUnit\Framework\TestCase;

class AnnotationLoaderTest extends TestCase
{
    public function testLoader(): void
    {
        $loader = new AnnotationDirectoryLoader();
        $loader->addPath(__DIR__.'/../Samples');
        $this->assertEquals(3, iterator_count($loader));
    }
}
