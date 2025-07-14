<?php

namespace Framework\ConfigReader;

class PHPConfigReader implements IConfigReader {
    /**
     * Get array of data stored in config/logger.php
     * @see config/logger.php
     */
    public static function getLoggerFile(): array
    {
        return require __DIR__ . '/../../config/logger.php';
    }

    /**
     * Get array of data stored in config/db.php
     * @see config/db.php
     */
    public static function getDatabaseFile(): array
    {
        return require __DIR__ . '/../../config/db.php';
    }
}
