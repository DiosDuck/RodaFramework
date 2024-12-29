<?php

namespace Framework;

abstract class AbstractController {
    public function __construct(
        private array $query, 
        private string $body
    ) {}

    /**
     * Get ALL query parameters from request
     * 
     * @return array
     */
    protected function getAllQuery(): array
    {
        return $this->query;
    }

    /**
     * Get query parameter by value
     */
    protected function getQueryByName(string $name, $default = null): mixed
    {
        return $this->query[$name] ?? $default;
    }

    /**
     * Get raw body from Request
     */
    protected function getRawBody(): string
    {
        return $this->body;
    }

    /**
     * Get the body from Request and converts it to JSON
     */
    protected function getBodyAsJson(): mixed
    {
        return json_decode($this->body);
    }

    /**
     * Renders view by name
     */
    protected function renderView(string $name, array $data = []): void
    {
        loadView($name, $data);
    }

    /**
     * Send the data in a Response code
     */
    protected function sendJsonResponse(array $data, int $code = 200): void
    {
        sendJson($data, $code);
    }

    /**
     * Redirects to the wanted URL
     */
    protected function redirectTo(string $url): void
    {
        redirect($url);
    }
}
