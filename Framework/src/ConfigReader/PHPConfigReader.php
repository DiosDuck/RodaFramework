<?php

namespace Framework\ConfigReader;

class PHPConfigReader implements IConfigReader {
    /**
     * Get array of data stored in App/config/logger.php
     * @see App/config/logger.php
     */
    public function getLoggerFile(): array
    {
        return require self::APP_PATH . '/config/logger.php';
    }

    /**
     * Get array of data stored in App/config/db.php
     * @see App/config/db.php
     */
    public static function getDatabaseFile(): array
    {
        return require self::APP_PATH . '/config/db.php';
    }

    /**
     * Get array of data stored in App/config/session.php
     * @see App/config/session.php
     */
    public function getSessionFile(): array
    {
        return require self::APP_PATH . '/config/session.php';
    }

    /**
     * Check if App/config/di.php exists
     * @see App/config/di.php
     */
    public static function hasDIAppFile(): bool
    {
        return file_exists(self::APP_PATH . '/config/di.php');
    }

    /**
     * Get array of data stored in App/config/di.php
     * @see App/config/di.php
     */
    public static function getDIAppFile(): array
    {
        return require self::APP_PATH . '/config/di.php';
    }

    /**
     * Get array of data stored in App/config/di.php
     * @see App/config/di.php
     */
    public static function getDIFrameworkFile(): array
    {
        return require self::FRAMEWORK_PATH . '/config/di.php';
    }
}
