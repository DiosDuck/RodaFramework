<?php

namespace Framework\Logger;

enum LogType {
    case ERROR;
    case INFO;
    case WARNING;
    case DEBUG;

    public function label(): string
    {
        return '[' . $this->name . ']';
    }
}
