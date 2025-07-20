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

    /**
     * Get array of data for session config
     */
    public static function getSessionFile(): array;
}
