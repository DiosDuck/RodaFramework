<?php

namespace App\Controllers;

use Framework\AbstractController;

class ErrorController extends AbstractController
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
