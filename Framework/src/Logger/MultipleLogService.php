<?php

namespace Framework\Logger;

use Framework\ConfigReader\IConfigReader;

class MultipleLogService implements ILogService {

    use LogTrait;

    private readonly array $paths;

    public function __construct(
        IConfigReader $configReader
    ) {
        $data = $configReader->getLoggerFile();
        if (isset($data['file']) && is_array($data['file'])) {
            $this->paths = $data['file'];
        } else if (isset($data['file'])) {
            $this->paths = [$data['file']];
        } else {
            $this->paths = [basePath('log.txt')];
        }
    }

    public function log(string $message, LogType $type = LogType::INFO): void
    {
        $log = $this->buildLogMessage($message, $type);
        $this->logMessageToPaths($log);
    }

    public function exceptionLog(\Throwable $e): void
    {
        $log = $this->buildErrorLogMessage($e);
        $this->logMessageToPaths($log);
    }

    private function logMessageToPaths(string $message): void
    {
        foreach ($this->paths as $path) {
            file_put_contents($path, $message, FILE_APPEND);
        }
    }
}