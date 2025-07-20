<?php

namespace Framework\Logger;

interface ILogService {
    public function log(string $message, LogType $type = LogType::INFO): void;
    public function exceptionLog(\Exception $e): void;
}
