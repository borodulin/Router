<?php

declare(strict_types=1);

namespace Borodulin\Router\Loader;

use Borodulin\Finder\ClassFinder;
use Borodulin\Finder\FinderInterface;
use Borodulin\Router\Annotation\Route;
use Borodulin\Router\Exception\InvalidConfigurationException;
use Borodulin\Router\RouteItem;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
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

            foreach ($classReflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
                $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, Route::class);
                if (null !== $annotation) {
                    yield $this->createMethodRouteItem($reflectionMethod, $annotation);
                }
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
        if (!$classReflection->implementsInterface(RequestHandlerInterface::class)) {
            throw new InvalidConfigurationException();
        }
        return (new RouteItem())
            ->setName($annotation->getName())
            ->setPath($annotation->getPath())
            ->setMethods($annotation->getMethods())
            ->setMiddlewares($annotation->getMiddlewares())
            ->setPriority($annotation->getPriority())
            ->setClass($classReflection->getName())
        ;
    }

    private function createMethodRouteItem(\ReflectionMethod $reflectionMethod, Route $annotation): RouteItem
    {
        return (new RouteItem())
            ->setName($annotation->getName())
            ->setPath($annotation->getPath())
            ->setMethods($annotation->getMethods())
            ->setMiddlewares($annotation->getMiddlewares())
            ->setPriority($annotation->getPriority())
            ->setClass($reflectionMethod->getDeclaringClass()->getName())
            ->setClassMethod($reflectionMethod->getName())
        ;
    }
}
