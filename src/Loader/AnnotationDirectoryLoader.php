<?php

declare(strict_types=1);

namespace Borodulin\Router\Loader;

use Borodulin\Finder\ClassFinder;
use Borodulin\Finder\FinderInterface;
use Borodulin\Router\Annotation\Route;
use Borodulin\Router\Collection\RouteItem;
use Borodulin\Router\Exception\InvalidConfigurationException;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AnnotationDirectoryLoader implements LoaderInterface
{
    /**
     * @var FinderInterface
     */
    private $classFinder;
    /**
     * @var SimpleAnnotationReader
     */
    private $annotationReader;

    public function __construct(FinderInterface $classFinder = null)
    {
        $this->classFinder = $classFinder ?: new ClassFinder();
        $this->annotationReader = new SimpleAnnotationReader();
        $this->annotationReader->addNamespace('Borodulin\Router\Annotation');
    }

    /**
     * @throws \ReflectionException
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->classFinder as $className) {
            $classReflection = new \ReflectionClass($className);
            $annotation = $this->annotationReader->getClassAnnotation(
                $classReflection,
                Route::class
            );

            if (null !== $annotation) {
                yield $this->createClassRouteItem($classReflection, $annotation);
            }
        }
    }

    public function addPath(string $path): FinderInterface
    {
        $this->classFinder->addPath($path);

        return $this;
    }

    private function createClassRouteItem(\ReflectionClass $classReflection, Route $annotation): RouteItem
    {
        if (
            !$classReflection->implementsInterface(RequestHandlerInterface::class)
            && !$classReflection->implementsInterface(MiddlewareInterface::class)
        ) {
            throw new InvalidConfigurationException();
        }

        return (new RouteItem())
            ->setName($annotation->getName())
            ->setPath($annotation->getPath())
            ->setMethods($annotation->getMethods())
            ->setTag($annotation->getTag())
            ->setPriority($annotation->getPriority())
            ->setOptions($annotation->getOptions())
            ->setTargetClass($classReflection->getName())
            ->setIsMiddleware($classReflection->implementsInterface(MiddlewareInterface::class))
            ->setIsRequestHandler($classReflection->implementsInterface(RequestHandlerInterface::class))
        ;
    }
}
