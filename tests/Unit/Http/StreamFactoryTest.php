<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Unit\Http;

use Borodulin\Router\Http\Factory\StreamFactory;
use PHPUnit\Framework\TestCase;

class StreamFactoryTest extends TestCase
{
    public function testMemoryStream(): void
    {
        $content = 'Hello world!';
        $stream = (new StreamFactory())
            ->createStream($content);

        $this->assertEquals($content, (string) $stream);
    }

    public function testFileStream(): void
    {
        $stream = (new StreamFactory())
            ->createStreamFromFile(__DIR__.'/../../Samples/ClassRouter.php');

        $this->assertNotEmpty((string) $stream);
    }

    public function testResourceStream(): void
    {
        $handle = fopen(__DIR__.'/../../Samples/ClassRouter.php', 'r');
        $stream = (new StreamFactory())
            ->createStreamFromResource($handle);

        $this->assertNotEmpty((string) $stream);
    }
}
