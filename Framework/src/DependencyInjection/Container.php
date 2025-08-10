<?php

namespace Framework\DependencyInjection;

use Framework\ConfigReader\EnvReader;

class Container {
    private static IContainerReader $containerReader;

    /**
     * Get anything from container (it will return mixed value)
     * 
     * @param string $name the id of the instance, mapped in dependency injection file
     * @return mixed the instance built
     */
    public static function get(string $name): mixed
    {
        self::initialize();

        return self::$containerReader->get($name);
    }


    /** 
     * Get object from container (with type hint of the class too)
     * 
     * @template T
     * @param class-string<T> $className the instance name and type, mapped in dependency injection file
     * @return T the instance built
     */
    public static function getObject(string $className): mixed
    {
        return self::get($className);
    }

    private static function initialize(): void
    {
        if (isset(self::$containerReader)) {
            return;
        }
        
        $format = EnvReader::getValue('FORMAT');
        self::$containerReader = match(strtolower($format)) {
            "php" =>  new PHPContainerReader(),
            default => new PHPContainerReader(),
        };
    }
}
