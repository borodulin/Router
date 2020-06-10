<?php

declare(strict_types=1);

namespace Borodulin\Router\Tests\Unit;

use Borodulin\Router\Loader\AnnotationDirectoryLoader;
use Borodulin\Router\RouterBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class RouterBuilderTest extends TestCase
{
    public function testBuilder(): void
    {
        $loader = (new AnnotationDirectoryLoader())
              ->addPath(__DIR__.'/../Samples');
        $builder = new RouterBuilder($loader);
        $handler = $builder->buildHandler();
        $request = $this->createRequest('/route', 'GET');
        $response = $handler->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    private function createRequest(string $path, string $method): ServerRequestInterface
    {
        return new class($path, $method) implements ServerRequestInterface {
            /**
             * @var string
             */
            private $path;
            /**
             * @var string
             */
            private $method;

            public function __construct(string $path, string $method)
            {
                $this->path = $path;
                $this->method = $method;
            }

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
             * @return string
             */
            public function getRequestTarget()
            {
                // TODO: Implement getRequestTarget() method.
            }

            /**
             * @param mixed $requestTarget
             *
             * @return $this
             */
            public function withRequestTarget($requestTarget)
            {
                // TODO: Implement withRequestTarget() method.
            }

            /**
             * @return string
             */
            public function getMethod()
            {
                return $this->method;
            }

            /**
             * @param string $method
             *
             * @return $this
             */
            public function withMethod($method)
            {
                // TODO: Implement withMethod() method.
            }

            /**
             * @return UriInterface
             */
            public function getUri()
            {
                return new class($this->path) implements UriInterface {
                    /**
                     * @var string
                     */
                    private $path;

                    public function __construct(string $path)
                    {
                        $this->path = $path;
                    }

                    /**
                     * @return string
                     */
                    public function getScheme()
                    {
                        // TODO: Implement getScheme() method.
                    }

                    /**
                     * @return string
                     */
                    public function getAuthority()
                    {
                        // TODO: Implement getAuthority() method.
                    }

                    /**
                     * @return string
                     */
                    public function getUserInfo()
                    {
                        // TODO: Implement getUserInfo() method.
                    }

                    /**
                     * @return string
                     */
                    public function getHost()
                    {
                        // TODO: Implement getHost() method.
                    }

                    /**
                     * @return int|null
                     */
                    public function getPort()
                    {
                        // TODO: Implement getPort() method.
                    }

                    /**
                     * @return string
                     */
                    public function getPath()
                    {
                        return $this->path;
                    }

                    /**
                     * @return string
                     */
                    public function getQuery()
                    {
                        // TODO: Implement getQuery() method.
                    }

                    /**
                     * @return string
                     */
                    public function getFragment()
                    {
                        // TODO: Implement getFragment() method.
                    }

                    /**
                     * @param string $scheme
                     *
                     * @return $this
                     */
                    public function withScheme($scheme)
                    {
                        // TODO: Implement withScheme() method.
                    }

                    /**
                     * @param string      $user
                     * @param string|null $password
                     *
                     * @return $this
                     */
                    public function withUserInfo($user, $password = null)
                    {
                        // TODO: Implement withUserInfo() method.
                    }

                    /**
                     * @param string $host
                     *
                     * @return $this
                     */
                    public function withHost($host)
                    {
                        // TODO: Implement withHost() method.
                    }

                    /**
                     * @param int|null $port
                     *
                     * @return $this
                     */
                    public function withPort($port)
                    {
                        // TODO: Implement withPort() method.
                    }

                    /**
                     * @param string $path
                     *
                     * @return $this
                     */
                    public function withPath($path)
                    {
                        // TODO: Implement withPath() method.
                    }

                    /**
                     * @param string $query
                     *
                     * @return $this
                     */
                    public function withQuery($query)
                    {
                        // TODO: Implement withQuery() method.
                    }

                    /**
                     * @param string $fragment
                     *
                     * @return $this
                     */
                    public function withFragment($fragment)
                    {
                        // TODO: Implement withFragment() method.
                    }

                    /**
                     * @return string
                     */
                    public function __toString()
                    {
                        // TODO: Implement __toString() method.
                    }
                };
            }

            /**
             * @param bool $preserveHost
             *
             * @return $this
             */
            public function withUri(UriInterface $uri, $preserveHost = false)
            {
                // TODO: Implement withUri() method.
            }

            /**
             * @return array
             */
            public function getServerParams()
            {
                // TODO: Implement getServerParams() method.
            }

            /**
             * @return array
             */
            public function getCookieParams()
            {
                // TODO: Implement getCookieParams() method.
            }

            /**
             * @return $this
             */
            public function withCookieParams(array $cookies)
            {
                // TODO: Implement withCookieParams() method.
            }

            /**
             * @return array
             */
            public function getQueryParams()
            {
                // TODO: Implement getQueryParams() method.
            }

            /**
             * @return $this
             */
            public function withQueryParams(array $query)
            {
                // TODO: Implement withQueryParams() method.
            }

            /**
             * @return array
             */
            public function getUploadedFiles()
            {
                // TODO: Implement getUploadedFiles() method.
            }

            /**
             * @return $this
             */
            public function withUploadedFiles(array $uploadedFiles)
            {
                // TODO: Implement withUploadedFiles() method.
            }

            /**
             * @return array|object|null
             */
            public function getParsedBody()
            {
                // TODO: Implement getParsedBody() method.
            }

            /**
             * @param array|object|null $data
             *
             * @return $this
             */
            public function withParsedBody($data)
            {
                // TODO: Implement withParsedBody() method.
            }

            /**
             * @return array
             */
            public function getAttributes()
            {
                // TODO: Implement getAttributes() method.
            }

            /**
             * @param string     $name
             * @param mixed|null $default
             *
             * @return mixed
             */
            public function getAttribute($name, $default = null)
            {
                // TODO: Implement getAttribute() method.
            }

            /**
             * @param string $name
             * @param mixed  $value
             *
             * @return $this
             */
            public function withAttribute($name, $value)
            {
                // TODO: Implement withAttribute() method.
            }

            /**
             * @param string $name
             *
             * @return $this
             */
            public function withoutAttribute($name)
            {
                // TODO: Implement withoutAttribute() method.
            }
        };
    }
}
