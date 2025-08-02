<?php

return [
    App\Controllers\ApiController::class => [

    ],
    
    App\Controllers\HomeController::class => [

    ],

    App\Controllers\AdminController::class => [

    ],

    App\Controllers\AdminApiController::class => [
        'args' => [
            Framework\Session\ISession::class,
        ]
    ]
];
