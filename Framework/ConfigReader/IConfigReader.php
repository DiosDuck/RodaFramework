<?php 

namespace Framework\ConfigReader;

interface IConfigReader {
    /**
     * Get array of data for logger config
     */
    public static function getLoggerFile(): array;

    /**
     * Get array of data for database config
     */
    public static function getDatabaseFile(): array;
}
