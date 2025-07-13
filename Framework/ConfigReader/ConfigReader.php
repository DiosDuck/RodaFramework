<?php

namespace Framework\ConfigReader;

class ConfigReader {
    public static function getLoggerPHPFile(): array
    {
        return require __DIR__ . '/../../config/logger.php';
    }
}
