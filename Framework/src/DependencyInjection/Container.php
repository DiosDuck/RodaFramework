<?php

namespace Framework\DependencyInjection;

use Exception;
use Framework\ConfigReader\PHPConfigReader;
use Framework\exceptions\DIException;
use ReflectionClass;

class Container
{
    private const METHOD_CONSTRUCT = '__construct';

    private static array $config = [];
    private static array $objectCache = [];

    /**
     * Prepare container
     */
    public static function construct(): void
    {
        if (PHPConfigReader::hasDIAppFile()) {
            self::$config = array_merge(
                PHPConfigReader::getDIFrameworkFile(),
                PHPConfigReader::getDIAppFile(),
            );
        }
    }

    /**
     * Get anything from container (it will return mixed value)
     * 
     * @param string $name the id of the instance, mapped in dependency injection file
     * @return mixed the instance built
     */
    public static function get(string $name): mixed
    {
        if (isset(self::$objectCache[$name])) {
            return self::$objectCache[$name];
        }

        if (!isset(self::$config[$name])) {
            return $name;
        }

        $class = self::$config[$name]['class'] ?? $name;
        $method = self::$config[$name]['method'] ?? self::METHOD_CONSTRUCT;
        try {
            $reflectionClass = new ReflectionClass($class);

            $paramRefs = self::$config[$name]['args'] ?? [];
            $params = [];
            foreach ($paramRefs as $paramRef) {
                $param = $paramRef;
                if (is_string($paramRef)) {
                    $param = self::get($paramRef);
                }

                $params[] = $param;
            }

            if ($method === self::METHOD_CONSTRUCT) {
                $object = $reflectionClass->newInstanceArgs($params);
            } else {
                $object = $reflectionClass->getMethod($method)->invokeArgs(null, $params);
            }

            self::$objectCache[$name] = $object;

            return $object;
        } catch (Exception) {
            throw new DIException("Class '$class' or method '$method' not accesible");
        }
    }

    /** 
     * Get class from container (with type hint too)
     * 
     * @template T
     * @param class-string<T> $className the instance name and type, mapped in dependency injection file
     * @return T the instance built
     */
    public static function getClass(string $className): mixed
    {
        return self::get($className);
    }
}
