<?php

declare(strict_types=1);

namespace Borodulin\Router\Parser;

class PathParser
{
    public function getPathParts($path): array
    {
        $path = rawurldecode($path);
        $path = trim($path, '/');

        return explode('/', $path);
//        $result = [];
//        foreach ($parts as $part) {
//            if (preg_match('/^{(.+?)}$/', $part, $matches)) {
//                $result[] =
//            }
//        }
    }

    public function isExpression($part): bool
    {
        return preg_match('/^{.+?}$/', $part) || preg_match('/^<.+?>$/', $part);
    }

    public function match(string $expression, string $part): bool
    {
        return true;
    }
}
