<?php

namespace Framework\Logger;

use Framework\ConfigReader\IConfigReader;

class LogService implements ILogService {

    use LogTrait;

    private readonly string $path;
    private static LogService $instance;

    public static function getLogger(IConfigReader $configReader): LogService
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($configReader);
        }

        return self::$instance;
    }

    private function __construct(IConfigReader $configReader) {
        $data = $configReader->getLoggerFile();
        if (!$data) {
            $this->path = basePath('log.text');
        } else {
            $this->path = $data['file'];
        }
    }

    public function log(string $message, LogType $type = LogType::INFO): void
    {
        $log = $this->buildLogMessage($message, $type);
        file_put_contents($this->path, $log, FILE_APPEND);
    }

    public function exceptionLog(\Throwable $e): void
    {
        $log = $this->buildErrorLogMessage($e);
        file_put_contents($this->path, $log, FILE_APPEND);
    }
}
