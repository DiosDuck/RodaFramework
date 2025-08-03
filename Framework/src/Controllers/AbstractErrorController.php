<?php

namespace Framework\Controllers;

abstract class AbstractErrorController extends AbstractViewController {
    /**
     * Render an error page
     * 
     * @param string $message the error message
     * @param int $code the error code
     */
    public abstract function renderError(string $message, int $code = 500);
}
