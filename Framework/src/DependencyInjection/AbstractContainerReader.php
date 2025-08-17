<?php

namespace Framework\DependencyInjection;

use Framework\exceptions\DIException;
use ReflectionClass;
use Exception;

abstract class AbstractContainerReader implements IContainerReader
{
    private const METHOD_CONSTRUCT = '__construct';

    protected array $config = [];
    private array $objectCache = [];

    /**
     * Get mixed value defined in dependency injection files
     * 
     * @param string $name the id of the instance, mapped in dependency injection file
     * @return mixed the instance built
     */
    public function get(string $name): mixed
    {
        if (isset($this->objectCache[$name])) {
            return $this->objectCache[$name];
        }

        if (!isset($this->config[$name])) {
            return $name;
        }

        $class = $this->config[$name]['class'] ?? $name;
        $method = $this->config[$name]['method'] ?? self::METHOD_CONSTRUCT;
        try {
            $reflectionClass = new ReflectionClass($class);

            $paramRefs = $this->config[$name]['args'] ?? [];
            $params = [];
            foreach ($paramRefs as $paramRef) {
                $param = $paramRef;
                if (is_string($paramRef)) {
                    $param = $this->get($paramRef);
                }

                $params[] = $param;
            }

            if ($method === self::METHOD_CONSTRUCT) {
                $object = $reflectionClass->newInstanceArgs($params);
            } else {
                $object = $reflectionClass->getMethod($method)->invokeArgs(null, $params);
            }

            $this->objectCache[$name] = $object;

            return $object;
        } catch (Exception) {
            throw new DIException("Class '$class' or method '$method' not accesible");
        }
    }
}
