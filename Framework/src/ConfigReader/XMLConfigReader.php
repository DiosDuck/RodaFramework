<?php

namespace Framework\ConfigReader;

class XMLConfigReader implements IConfigReader {
    /**
     * Get array of app data for logger config
     */
    public function getLoggerFile(): array
    {
        return $this->readFile(self::APP_PATH . '/config/logger.xml');
    }

    /**
     * Get array of app data for database config
     */
    public function getDatabaseFile(): array
    {
        return $this->readFile(self::APP_PATH . '/config/db.xml');
    }

    /**
     * Get array of app data for session config
     */
    public function getSessionFile(): array
    {
        return [];
    }

    /**
     * Check if app dependency injection config file exists
     */
    public static function hasDIAppFile(): bool
    {
        return false;
    }

    /**
     * Get array of app data for dependency injection config
     */
    public static function getDIAppFile(): array
    {
        return [];
    }

    /**
     * Get array of framework data for dependency injection config
     */
    public static function getDIFrameworkFile(): array
    {
        return [];
    }

    private static function readFile(string $filename): array
    {
        $xml = simplexml_load_file($filename);
        return json_decode(json_encode($xml), true);
    }
}
