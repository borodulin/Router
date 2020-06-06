<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Samples;

use Borodulin\Router\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
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
        return new class() implements ResponseInterface {
            /**
             * @return string
             */
            public function getProtocolVersion()
            {
                // TODO: Implement getProtocolVersion() method.
            }

            /**
             * @param string $version
             *
             * @return $this
             */
            public function withProtocolVersion($version)
            {
                // TODO: Implement withProtocolVersion() method.
            }

            /**
             * @return \string[][]
             */
            public function getHeaders()
            {
                // TODO: Implement getHeaders() method.
            }

            /**
             * @param string $name
             *
             * @return bool
             */
            public function hasHeader($name)
            {
                // TODO: Implement hasHeader() method.
            }

            /**
             * @param string $name
             *
             * @return string[]
             */
            public function getHeader($name)
            {
                // TODO: Implement getHeader() method.
            }

            /**
             * @param string $name
             *
             * @return string
             */
            public function getHeaderLine($name)
            {
                // TODO: Implement getHeaderLine() method.
            }

            /**
             * @param string          $name
             * @param string|string[] $value
             *
             * @return $this
             */
            public function withHeader($name, $value)
            {
                // TODO: Implement withHeader() method.
            }

            /**
             * @param string          $name
             * @param string|string[] $value
             *
             * @return $this
             */
            public function withAddedHeader($name, $value)
            {
                // TODO: Implement withAddedHeader() method.
            }

            /**
             * @param string $name
             *
             * @return $this
             */
            public function withoutHeader($name)
            {
                // TODO: Implement withoutHeader() method.
            }

            /**
             * @return StreamInterface
             */
            public function getBody()
            {
                // TODO: Implement getBody() method.
            }

            /**
             * @return $this
             */
            public function withBody(StreamInterface $body)
            {
                // TODO: Implement withBody() method.
            }

            /**
             * @return int
             */
            public function getStatusCode()
            {
                return 200;
            }

            /**
             * @param int    $code
             * @param string $reasonPhrase
             *
             * @return $this
             */
            public function withStatus($code, $reasonPhrase = '')
            {
                // TODO: Implement withStatus() method.
            }

            /**
             * @return string
             */
            public function getReasonPhrase()
            {
                // TODO: Implement getReasonPhrase() method.
            }
        };
    }
}
