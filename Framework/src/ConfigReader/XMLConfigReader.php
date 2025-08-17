<?php

namespace Framework\ConfigReader;

use SimpleXMLElement;

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
     * Get SimpleXMLElement of app data for dependency injection config
     */
    public static function getDIAppFile(): ?SimpleXMLElement
    {
        if ($xml = simplexml_load_file(self::APP_PATH . '/config/di.xml')) {
            return $xml;
        }

        return null;
    }

    /**
     * Get SimpleXMLElement of framework data for dependency injection config
     */
    public static function getDIFrameworkFile(): ?SimpleXMLElement
    {
        if ($xml = simplexml_load_file(self::FRAMEWORK_PATH . '/config/di.xml')) {
            return $xml;
        }

        return null;
    }

    private static function readFile(string $filename): array
    {
        if (!$xml = simplexml_load_file($filename)) {
            return [];
        }

        return json_decode(json_encode($xml), true);
    }
}
