<?php

return [
    Framework\Router\IRouter::class => [
        'class' => Framework\Router\Router::class,
        'args' => [
            Framework\Logger\ILogService::class,
            Framework\Session\ISession::class,
            Framework\Authorization\IAuthorizationService::class,
        ]
    ],

    Framework\Logger\ILogService::class => [
        'class' => Framework\Logger\MultipleLogService::class,
        'args' => [
            Framework\ConfigReader\IConfigReader::class,
        ],
    ],

    Framework\Session\ISession::class => [
        'class' => \Framework\Session\Session::class,
        'args' => [
            Framework\ConfigReader\IConfigReader::class,
        ],
    ],

    Framework\ConfigReader\IConfigReader::class => [
        'class' => Framework\ConfigReader\PHPConfigReader::class,
    ],

    Framework\Authorization\IAuthorizationService::class => [
        'class' => Framework\Authorization\AuthorizationService::class,
        'args' => [
            Framework\Session\ISession::class,
        ]
    ],

    Framework\Database\AbstractDatabase::class => [
        'class' => Framework\Database\MySQLDatabase::class,
        'args' => [
            Framework\ConfigReader\IConfigReader::class,
        ]
    ],

    Framework\Controllers\AbstractErrorController::class => [
        'class' => Framework\Controllers\ErrorController::class,
    ],

    Framework\ConfigReader\XMLConfigReader::class => [
        
    ]
];
