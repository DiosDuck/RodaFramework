<?php

namespace Framework\ConfigReader;

class PHPConfigReader implements IConfigReader {
    /**
     * Get array of data stored in App/config/logger.php
     * @see App/config/logger.php
     */
    public function getLoggerFile(): array
    {
        if ($data = self::getFileDataOrDefault(self::APP_PATH . '/config/logger.php')) {
            return $data;
        }

        return self::getFileDataOrDefault(self::FRAMEWORK_PATH . '/config/logger.php');
    }

    /**
     * Get array of data stored in App/config/db.php
     * @see App/config/db.php
     */
    public function getDatabaseFile(): array
    {
        return self::getFileDataOrDefault(self::APP_PATH . '/config/db.php');
    }

    /**
     * Get array of data stored in App/config/session.php
     * @see App/config/session.php
     */
    public function getSessionFile(): array
    {
        return self::getFileDataOrDefault(self::APP_PATH . '/config/session.php');
    }
    
    /**
     * Get array of data stored in App/config/di.php
     * @see App/config/di.php
     */
    public static function getDIAppFile(): array
    {
        return self::getFileDataOrDefault(self::APP_PATH . '/config/di.php');
    }

    /**
     * Get array of data stored in App/config/di.php
     * @see App/config/di.php
     */
    public static function getDIFrameworkFile(): array
    {
        return self::getFileDataOrDefault(self::FRAMEWORK_PATH . '/config/di.php');
    }

    private static function getFileDataOrDefault(string $name): array
    {
        if (!file_exists($name)) {
            return [];
        }

        return require $name;
    }
}
