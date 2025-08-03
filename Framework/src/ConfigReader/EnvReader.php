<?php

namespace Framework\ConfigReader;

class EnvReader {
    private array $data;
    private static EnvReader $envReader;

    private function __construct()
    {
        $this->data = readEnvFile();
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $envReader = self::getEnvReader();
        return $envReader->data[$key] ?? $default;
    }

    private static function getEnvReader(): EnvReader
    {
        if (!isset(self::$envReader)) {
            self::$envReader = new EnvReader();
        }
        return self::$envReader;
    }
}