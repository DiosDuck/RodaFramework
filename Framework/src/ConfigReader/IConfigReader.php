<?php 

namespace Framework\ConfigReader;

interface IConfigReader {
    public const APP_PATH = __DIR__ . '/../../../App';
    public const FRAMEWORK_PATH = __DIR__ . '/../..';

    /**
     * Get array of app data for logger config
     */
    public function getLoggerFile(): array;

    /**
     * Get array of app data for database config
     */
    public static function getDatabaseFile(): array;

    /**
     * Get array of app data for session config
     */
    public function getSessionFile(): array;

    /**
     * Check if app dependency injection config file exists
     */
    public static function hasDIAppFile(): bool;

    /**
     * Get array of app data for dependency injection config
     */
    public static function getDIAppFile(): array;

    /**
     * Get array of framework data for dependency injection config
     */
    public static function getDIFrameworkFile(): array;
}
