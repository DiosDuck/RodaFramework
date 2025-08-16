<?php

namespace Framework\ConfigReader;

class XMLConfigReader implements IConfigReader {
    /**
     * Get array of app data for logger config
     */
    public function getLoggerFile(): array
    {
        if ($data = self::readFile(self::APP_PATH . '/config/logger.xml')) {
            return $data;
        }

        return self::readFile(self::FRAMEWORK_PATH . '/config/logger.xml');
    }

    /**
     * Get array of app data for database config
     */
    public function getDatabaseFile(): array
    {
        return self::readFile(self::APP_PATH . '/config/db.xml');
    }

    /**
     * Get array of app data for session config
     */
    public function getSessionFile(): array
    {
        return self::readFile(self::APP_PATH . '/config/session.xml');
    }

    /**
     * Check if app dependency injection config file exists
     */
    public static function hasDIAppFile(): bool
    {
        return file_exists(self::APP_PATH . '/config/di.xml');
    }

    /**
     * Get array of app data for dependency injection config
     */
    public static function getDIAppFile(): array
    {
        return self::readFile(self::APP_PATH . '/config/di.xml');
    }

    /**
     * Get array of framework data for dependency injection config
     */
    public static function getDIFrameworkFile(): array
    {
        return self::readFile(self::FRAMEWORK_PATH . '/config/di.xml');
    }

    private static function readFile(string $filename): array
    {
        if (!$xml = simplexml_load_file($filename)) {
            return [];
        }
        
        return json_decode(json_encode($xml), true);
    }
}
