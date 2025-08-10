<?php

namespace Framework\Logger;

trait LogTrait {
    private function buildLogMessage(string $message, LogType $log): string
    {
        return sprintf('%s %s %s', date('[Y-m-d H:m:i]'), $log->label(), $message) . PHP_EOL;
    }

    private function buildErrorLogMessage(\Throwable $e): string
    {
        $log = $this->buildLogMessage($e->getMessage(), LogType::ERROR);
        foreach ($e->getTrace() as $trace) {
            $log .= sprintf('  %s:%s', $trace['file'], $trace['line']) . PHP_EOL;
        }

        return $log;
    }
}
