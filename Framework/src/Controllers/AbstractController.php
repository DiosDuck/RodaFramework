<?php

namespace Framework\Controllers;

abstract class AbstractController {
    private array $query = [];
    private string $rawBody = "{}";

    /**
     * set all request query parameters
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * set raw request body
     */
    public function setRawBody(string $rawBody): void
    {
        $this->rawBody = $rawBody;
    }

    /**
     * get all query parameters
     */
    protected function getAllQueries(): array
    {
        return $this->query;
    }

    /**
     * get a single query parameter by name
     */
    protected function getQueryByName(string $name, mixed $default = null): mixed
    {
        return $this->query[$name] ?? $default;
    }

    /**
     * get the raw body from request
     */
    protected function getRawBody(): string
    {
        return $this->rawBody;
    }

    /**
     * get the json body from request;
     */
    protected function getJsonBody(?bool $associtive = true): mixed
    {
        return json_decode($this->rawBody, $associtive);
    }
}
