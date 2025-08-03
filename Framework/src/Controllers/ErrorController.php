<?php

namespace Framework\Controllers;

class ErrorController extends AbstractErrorController {
    public function renderError(string $message, int $code = 500): void
    {
        setResponseCode($code);
        $this->setTItle(ucwords($message));
        $this->renderView('error/index', ['message' => $message, 'code' => $code]);
    }
}
