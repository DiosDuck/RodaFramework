<?php

namespace Framework;

class Logger
{
    public const LOG_FILE = '../log.txt';

    public const ERROR_LOG = '[ERROR]';
    public const INFO_LOG = '[INFO]';
    public const WARNING_LOG = '[WARNING]';

    public static function log(string $message, string $type = self::INFO_LOG): void
    {
        $log = date('Y-m-d H:i:s') . ' ' . $type . ' ' . $message . PHP_EOL;
        file_put_contents(self::LOG_FILE, $log, FILE_APPEND);
    }

    public static function exceptionLog(\Exception $e): void
    {
        $log = date('Y-m-d H:i:s') . ' ' . self::ERROR_LOG . ' ' . $e->getMessage() . PHP_EOL;
        foreach ($e->getTrace() as $trace) {
            $log .= '    ' . $trace['file'] . ':' . $trace['line'] . PHP_EOL;
        }
        file_put_contents(self::LOG_FILE, $log, FILE_APPEND);
    }
}
