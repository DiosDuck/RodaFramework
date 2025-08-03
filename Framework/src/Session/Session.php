<?php

namespace Framework\Session;

use Framework\ConfigReader\IConfigReader;

class Session implements ISession {
    private array $options;

    public function __construct(IConfigReader $configReader) {
        $this->options = $configReader->getSessionFile();
    }

    public function start(): void 
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start($this->options);
        }
    }

    public function set(string $key, mixed $value): void 
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed 
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function has(string $key): bool 
    {
        return isset($_SESSION[$key]);
    }

    public function clear(string $key): void 
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function clearAll(): void 
    {
        session_unset();
        session_destroy();
    }
}
