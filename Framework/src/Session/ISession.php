<?php

namespace Framework\Session;

interface ISession {
    /**
     * Start the session
     */
    public function start(): void;

    /**
     * Set a session key/value pair
     */
    public function set(string $key, mixed $value): void;

    /**
     * Get a session value by key
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Check if session key exists
     */
    public function has(string $key): bool;

    /**
     * Clear session by key
     */
    public function clear(string $key): void;

    /**
     * Clear all session data
     */
    public function clearAll(): void;
}
