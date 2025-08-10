<?php

return [
    'host' => '',
    'port' => '',
    'dbname' => '',
    'username' => '',
    'password' => '',
    'options' => [
        [
            'key' => PDO::ATTR_ERRMODE,
            'value' => PDO::ERRMODE_EXCEPTION,
        ],
        [
            'key' => PDO::ATTR_DEFAULT_FETCH_MODE,
            'value' => PDO::FETCH_OBJ,
        ]
    ],
];
