<?php

namespace Framework\DependencyInjection;

interface IContainerReader {
    /**
     * Get anything from container (it will return mixed value)
     * 
     * @param string $name the id of the instance, mapped in dependency injection file
     * @return mixed the instance built
     */
    public function get(string $name): mixed;

    /** 
     * Get class from container (with type hint too)
     * 
     * @template T
     * @param class-string<T> $className the instance name and type, mapped in dependency injection file
     * @return T the instance built
     */
    public function getClass(string $name): mixed;
}
