<?php

namespace Framework\Controllers;

abstract class AbstractAPIController extends AbstractController {

    /**
     * send JSON response to the request
     */
    protected function sendJsonResponse(array $data, int $code = 200): void
    {
        sendJson($data, $code);
    }
}
