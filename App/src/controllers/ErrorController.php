<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class ErrorController extends AbstractViewController
{
    public static function notFound(): void
    {
        setResponseCode(404);
        render('errors/404', ['heads' => ['title' => 'Not Found']]);
    }

    public static function internalServerError(): void
    {
        setResponseCode(500);
        render('errors/500', ['heads' => ['title' => 'Internal Server Error']]);
    }

    public static function forbidden(): void
    {
        setResponseCode(401);
        render('errors/401', ['heads' => ['title' => 'Forbidden']]);
    }
}
