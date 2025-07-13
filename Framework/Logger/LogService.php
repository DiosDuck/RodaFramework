<?php

namespace Framework\Logger;

use Framework\ConfigReader\ConfigReader;

class LogService {
    private readonly string $path;
    private static LogService $instance;

    public static function getLogger(): LogService
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $data = ConfigReader::getLoggerPHPFile();
        if (!$data) {
            $this->path = '../../log.txt';
        } else {
            $this->path = $data['file'];
        }
    }

    public function log(string $message, LogType $type = LogType::INFO): void
    {
        $log = date('Y-m-d H:i:s') . ' ' . $type->label() . ' ' . $message . PHP_EOL;
        file_put_contents($this->path, $log, FILE_APPEND);
    }

    public function exceptionLog(\Exception $e): void
    {
        $log = date('Y-m-d H:i:s') . ' ' . LogType::ERROR->label() . ' ' . $e->getMessage() . PHP_EOL;
        foreach ($e->getTrace() as $trace) {
            $log .= '    ' . $trace['file'] . ':' . $trace['line'] . PHP_EOL;
        }
        file_put_contents($this->path, $log, FILE_APPEND);
    }
}
