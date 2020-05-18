<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Unit\Http;

use Borodulin\Router\Http\Factory\StreamFactory;
use Borodulin\Router\Http\Stream\InvalidStreamException;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function testStream(): void
    {
        $stream = (new StreamFactory())->createStream('Sample');
        $stream->write(' Test');
        $this->assertEquals('Sample Test', (string) $stream);

        $stream->seek(7);
        $this->assertEquals(7, $stream->tell());
        $this->assertEquals('Test', $stream->getContents());
        $stream->rewind();
        $this->assertEquals('Sample Test', $stream->read(1000));
        $this->assertNull($stream->getMetadata('size'));
        $this->assertTrue($stream->isWritable());
        $this->assertTrue($stream->isSeekable());
        $this->assertTrue($stream->isReadable());
        $this->assertTrue($stream->eof());
        $stream->rewind();
        $this->assertFalse($stream->eof());
        $this->assertIsArray($stream->getMetadata());
        $this->assertEquals(11, $stream->getSize());

        $stream->close();
        $this->assertEquals('', (string) $stream);
        $stream->close();
        $this->expectException(InvalidStreamException::class);
        $stream->getContents();
    }
}
