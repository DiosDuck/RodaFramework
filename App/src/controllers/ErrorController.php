<?php

namespace App\Controllers;

use Framework\Controllers\AbstractViewController;

class ErrorController extends AbstractViewController
{
    public static function notFound()
    {
        loadView('errors/404');
    }

    public static function internalServerError()
    {
        loadView('errors/500');
    }
}
