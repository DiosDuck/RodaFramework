<?php

namespace Framework\DependencyInjection;

interface IContainerReader {
    /**
     * Get mixed value defined in dependency injection files
     * 
     * @param string $name the id of the instance, mapped in dependency injection file
     * @return mixed the instance built
     */
    public function get(string $name): mixed;
}
