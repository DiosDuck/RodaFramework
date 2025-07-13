<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class ErrorController extends AbstractViewController
{
    public static function notFound()
    {
        setResponseCode(404);
        render('errors/404', ['heads' => ['title' => 'Not Found']]);
    }

    public static function internalServerError()
    {
        setResponseCode(500);
        render('errors/500', ['heads' => ['title' => 'Internal Server Error']]);
    }
}
